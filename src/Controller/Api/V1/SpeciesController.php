<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Table\SpeciesTable;
use App\Model\Entity\Species;
use App\Model\Table\UsersTable;
use App\Error\Api\BadRequestError;
use App\Error\Api\NotFoundError;
use App\Error\Api\UnauthorizedError;

/**
 * Species Controller
 *
 * @property SpeciesTable $Species
 */
class SpeciesController extends ApiAppController
{
    public function view(int $campaignId, int $id): void
    {
        $species = $this->Species->findByIdAndCampaignId(campaignId: $campaignId, id: $id);

        if ($species === null) {
            throw new NotFoundError(message: "Species $id not found");
        }

        $this->isAuthorized(entity: $species);

        $this->output(compact('species'));
    }

    public function index(int $campaignId): void
    {
        $species = $this->Species->findByCampaignIdWithPermissionsCheck(
            identity: $this->user,
            campaignId: $campaignId
        )->all()->toList();

        // Skip the authorization because it happens when we get the entities from the DB
        $this->Authorization->skipAuthorization();

        $this->output(['species' => $species]);
    }

    public function add(int $campaignId): void
    {
        $data = $this->request->getData();
        $data[Species::FIELD_CAMPAIGN_ID] = $campaignId;
        $data[Species::FIELD_USER_ID] = $this->user['id'];

        /** @var Species $species */
        $species = $this->Species->newEmptyEntity();

        $species->setAccess(field: Species::FIELD_USER_ID, set: true);
        $species->setAccess(field: Species::FIELD_CAMPAIGN_ID, set: true);
        $species = $this->Species->patchEntity(
            entity: $species,
            data: $data
        );

        $this->isAuthorized(entity: $species);

        if ($this->Species->save(entity: $species)) {
            $this->output(compact('species'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse(response: $this->response);
        } elseif ($species->getErrors()) {
            throw new BadRequestError(message: "Error adding Species", errors: $species->getErrors());
        }
    }

    public function edit(int $campaignId, int $id): void
    {
        $species = $this->Species->get(primaryKey: $id, contain: 'Users');

        if ($species === null) {
            throw new NotFoundError(message: "Species $id not found");
        }

        $data = $this->request->getData();

        $this->isAuthorized(entity: $species);

        $species = $this->Species->patchEntity(entity: $species, data: $data);

        if ($this->Species->save(entity: $species)) {
            $this->output(compact('species'));
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error saving Species: $id", errors: $species->getErrors());
        }
    }

    public function delete(int $campaignId, int $id): void
    {
        $species = $this->Species->get(primaryKey: $id, contain: 'Users');

        $this->isAuthorized(entity: $species);

        if ($species === null || $species->campaign_id !== $campaignId) {
            throw new NotFoundError(message: "Species $id not found");
        }

        if ($this->Species->delete(entity: $species)) {
            $this->output([]);
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error deleting Species: $id", errors: $species->getErrors());
        }
    }
}
