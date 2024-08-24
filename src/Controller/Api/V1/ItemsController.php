<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Table\ItemsTable;
use App\Model\Entity\Item;
use App\Model\Table\UsersTable;
use App\Error\Api\BadRequestError;
use App\Error\Api\NotFoundError;
use App\Error\Api\UnauthorizedError;

/**
 * Item Controller
 *
 * @property ItemsTable $Items
 */
class ItemsController extends ApiAppController
{
    public function view(int $campaignId, int $id): void
    {
        $item = $this->Items->findByIdAndCampaignId(campaignId: $campaignId, id: $id);

        if ($item === null) {
            throw new NotFoundError(message: "Item $id not found");
        }

        $this->isAuthorized(entity: $item);

        $this->output(compact('item'));
    }

    public function index(int $campaignId): void
    {
        $items = $this->Items->findByCampaignIdWithPermissionsCheck(
            identity: $this->user,
            campaignId: $campaignId
        )->all()->toList();

        // Skip the authorization because it happens when we get the entities from the DB
        $this->Authorization->skipAuthorization();

        $this->output(['items' => $items]);
    }

    public function add(int $campaignId): void
    {
        $data = $this->request->getData();
        $data[Item::FIELD_CAMPAIGN_ID] = $campaignId;
        $data[Item::FIELD_USER_ID] = $this->user['id'];

        /** @var Item $item */
        $item = $this->Items->newEmptyEntity();

        $item->setAccess(field: Item::FIELD_USER_ID, set: true);
        $item->setAccess(field: Item::FIELD_CAMPAIGN_ID, set: true);
        $item = $this->Items->patchEntity(
            entity: $item,
            data: $data
        );

        $this->isAuthorized(entity: $item);

        if ($this->Items->save(entity: $item)) {
            $this->output(compact('item'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse(response: $this->response);
        } elseif ($item->getErrors()) {
            throw new BadRequestError(message: "Error adding Item", errors: $item->getErrors());
        }
    }

    public function edit(int $campaignId, int $id): void
    {
        $item = $this->Items->get(primaryKey: $id, contain: 'Users');

        if ($item === null) {
            throw new NotFoundError(message: "Item $id not found");
        }

        $data = $this->request->getData();

        $this->isAuthorized(entity: $item);

        $item = $this->Items->patchEntity(entity: $item, data: $data);

        if ($this->Items->save(entity: $item)) {
            $this->output(compact('item'));
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error saving Item: $id", errors: $item->getErrors());
        }
    }

    public function delete(int $campaignId, int $id): void
    {
        $item = $this->Items->get(primaryKey: $id, contain: 'Users');

        $this->isAuthorized(entity: $item);

        if ($item === null || $item->campaign_id !== $campaignId) {
            throw new NotFoundError(message: "Item $id not found");
        }

        if ($this->Items->delete(entity: $item)) {
            $this->output([]);
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error deleting Item: $id", errors: $item->getErrors());
        }
    }
}
