<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Table\CharactersTable;
use App\Model\Entity\Character;
use App\Model\Table\UsersTable;
use App\Error\Api\BadRequestError;
use App\Error\Api\NotFoundError;
use App\Error\Api\UnauthorizedError;
use App\Model\Entity\User;

/**
 * Character Controller
 *
 * @property CharactersTable $Characters
 */
class CharactersController extends ApiAppController
{
    public function view(int $campaignId, int $id): void
    {
        $character = $this->Characters->findByIdAndCampaignId(campaignId: $campaignId, id: $id);

        if ($character === null) {
            throw new NotFoundError(message: "Character $id not found");
        }

        $this->isAuthorized(entity: $character);

        $this->output(compact('character'));
    }

    public function index(int $campaignId): void
    {
        $characters = $this->Characters->findByCampaignIdWithPermissionsCheck(
            identity: $this->user,
            campaignId: $campaignId,
        )->all()->toList();

        // Skip the authorization because it happens when we get the entities from the DB
        $this->Authorization->skipAuthorization();

        $this->output(['characters' => $characters]);
    }

    public function add(int $campaignId): void
    {
        $data = $this->request->getData();
        $data[Character::FIELD_CAMPAIGN_ID] = $campaignId;
        $data[Character::FIELD_USER_ID] = $this->user['id'];

        /** @var Character $character */
        $character = $this->Characters->newEmptyEntity();

        $character->setAccess(field: Character::FIELD_USER_ID, set: true);
        $character->setAccess(field: Character::FIELD_CAMPAIGN_ID, set: true);
        $character = $this->Characters->patchEntity(
            entity: $character,
            data: $data
        );

        $this->isAuthorized(entity: $character);

        if ($this->Characters->save(entity: $character)) {
            $this->output(compact('character'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse(response: $this->response);
        } elseif ($character->getErrors()) {
            throw new BadRequestError(message: "Error adding Character", errors: $character->getErrors());
        }
    }

    public function edit(int $campaignId, int $id): void
    {
        $character = $this->Characters->get(primaryKey: $id, contain: User::ENTITY_NAME);

        if ($character === null) {
            throw new NotFoundError(message: "Character $id not found");
        }

        $data = $this->request->getData();

        $this->isAuthorized(entity: $character);

        $character = $this->Characters->patchEntity(entity: $character, data: $data);

        if ($this->Characters->save(entity: $character)) {
            $this->output(compact('character'));
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error saving Character: $id", errors: $character->getErrors());
        }
    }

    public function delete(int $campaignId, int $id): void
    {
        $character = $this->Characters->get(primaryKey: $id, contain: User::ENTITY_NAME);

        $this->isAuthorized(entity: $character);

        if ($character === null || $character->campaign_id !== $campaignId) {
            throw new NotFoundError(message: "Character $id not found");
        }

        if ($this->Characters->delete(entity: $character)) {
            $this->output([]);
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error deleting Character: $id", errors: $character->getErrors());
        }
    }
}
