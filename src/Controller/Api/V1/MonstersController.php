<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Table\MonstersTable;
use App\Model\Entity\Monster;
use App\Model\Table\UsersTable;
use App\Error\Api\BadRequestError;
use App\Error\Api\NotFoundError;
use App\Error\Api\UnauthorizedError;
use App\Model\Entity\User;

/**
 * Monster Controller
 *
 * @property MonstersTable $Monsters
 */
class MonstersController extends ApiAppController
{
    public function view(int $campaignId, int $id): void
    {
        $monster = $this->Monsters->findByIdAndCampaignId(campaignId: $campaignId, id: $id);

        if ($monster === null) {
            throw new NotFoundError(message: "Monster $id not found");
        }

        $this->isAuthorized(entity: $monster);

        $this->output(compact('monster'));
    }

    public function index(int $campaignId): void
    {
        $monsters = $this->Monsters->findByCampaignIdWithPermissionsCheck(
            identity: $this->user,
            campaignId: $campaignId,
        )->all()->toList();

        // Skip the authorization because it happens when we get the entities from the DB
        $this->Authorization->skipAuthorization();

        $this->output(['monsters' => $monsters]);
    }

    public function add(int $campaignId): void
    {
        $data = $this->request->getData();
        $data[Monster::FIELD_CAMPAIGN_ID] = $campaignId;
        $data[Monster::FIELD_USER_ID] = $this->user['id'];

        /** @var Monster $monster */
        $monster = $this->Monsters->newEmptyEntity();

        $monster->setAccess(field: Monster::FIELD_USER_ID, set: true);
        $monster->setAccess(field: Monster::FIELD_CAMPAIGN_ID, set: true);
        $monster = $this->Monsters->patchEntity(
            entity: $monster,
            data: $data
        );

        $this->isAuthorized(entity: $monster);

        if ($this->Monsters->save(entity: $monster)) {
            $this->output(compact('monster'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse(response: $this->response);
        } elseif ($monster->getErrors()) {
            throw new BadRequestError(message: "Error adding Monster", errors: $monster->getErrors());
        }
    }

    public function edit(int $campaignId, int $id): void
    {
        $monster = $this->Monsters->get(primaryKey: $id, contain: User::ENTITY_NAME);

        if ($monster === null) {
            throw new NotFoundError(message: "Monster $id not found");
        }

        $data = $this->request->getData();

        $this->isAuthorized(entity: $monster);

        $monster = $this->Monsters->patchEntity(entity: $monster, data: $data);

        if ($this->Monsters->save(entity: $monster)) {
            $this->output(compact('monster'));
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error saving Monster: $id", errors: $monster->getErrors());
        }
    }

    public function delete(int $campaignId, int $id): void
    {
        $monster = $this->Monsters->get(primaryKey: $id, contain: User::ENTITY_NAME);

        $this->isAuthorized(entity: $monster);

        if ($monster === null || $monster->campaign_id !== $campaignId) {
            throw new NotFoundError(message: "Monster $id not found");
        }

        if ($this->Monsters->delete(entity: $monster)) {
            $this->output([]);
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error deleting Monster: $id", errors: $monster->getErrors());
        }
    }
}
