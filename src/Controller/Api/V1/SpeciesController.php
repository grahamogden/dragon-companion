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
        $user = $this->user;

        if ($user === null) {
            throw new UnauthorizedError();
        }

        $species = $this->Species->findByCampaignId(campaignId: $campaignId);

        if (count($species) === 0) {
            // If there are no species, then we can't authorize for anything
            $this->Authorization->skipAuthorization();
        }

        $outputSpecies = [];
        foreach ($species as $specum) {
            if ($this->isAuthorizedCheck(entity: $specum)) {
                $outputSpecies[] = $specum;
            }
        }

        $this->output(['species' => $outputSpecies]);
    }

    public function add(int $campaignId): void
    {
        $data = $this->request->getData();
        $data[Species::FIELD_CAMPAIGN_ID] = $campaignId;
        $data[Species::FIELD_USER_ID] = $this->user['id'];

        /** @var Species $species */
        $species = $this->Species->newEmptyEntity();

        $species->setAccess(field: UsersTable::TABLE_NAME, set: true);
        $species = $this->Species->patchEntity(
            entity: $species,
            data: $data
        );

        $this->isAuthorized(entity: $species);

        if ($this->Species->save(entity: $species)) {
            $this->output(compact('species'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse(response: $this->response);
        } elseif ($species->getErrors()) {
            throw new BadRequestError(errors: $species->getErrors());
        }
    }

    // private function addDefaultRolesAndPermissions(Species $species): void
    // {
    //     $rolesTable = $this->fetchTable(RolesTable::class);
    //     $creatorRole = $rolesTable->findByCampaignId($species->campaign_id);

    //     // Link the user to the newly created "Creator" role for this species
    //     $rolesTable->Users->link($creatorRole, [$this->user]);

    //     $this->addCreatorSpeciesPermissionForUser(species: $species, creatorRole: $creatorRole);
    // }

    // private function addCreatorSpeciesPermissionForUser(Species $species, Role $creatorRole): void
    // {
    //     $speciesPermissionsTable = $this->fetchTable(SpeciesPermissionsTable::class);
    //     /** @var SpeciesPermission $speciesPermissions */
    //     $speciesPermission = $speciesPermissionsTable->newEmptyEntity();
    //     $speciesPermissionsTable->patchEntity(
    //         entity: $speciesPermission,
    //         data: [
    //             SpeciesPermission::FIELD_SPECIES_ID => $species->id,
    //             SpeciesPermission::FIELD_ROLE_ID => $creatorRole->getId(),
    //             SpeciesPermission::FIELD_CAN_READ => true,
    //             SpeciesPermission::FIELD_CAN_WRITE => true,
    //             SpeciesPermission::FIELD_CAN_DELETE => true,
    //             SpeciesPermission::FIELD_CAN_PERMISSION => true,
    //         ],
    //     );

    //     if (!$speciesPermissionsTable->save(entity: $speciesPermission)) {
    //         throw new BadRequestError(errors: $speciesPermission->getErrors());
    //     }
    // }

    public function edit(int $campaignId, int $id): void
    {
        $species = $this->Species->get(primaryKey: $id, contain: 'Users');
        $data = $this->request->getData();

        $this->isAuthorized(entity: $species);

        $species = $this->Species->patchEntity(entity: $species, data: $data);

        if ($this->Species->save(entity: $species)) {
            $this->output(compact('species'));
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new NotFoundError(message: "Species $id not found");
        }
    }

    public function delete(int $campaignId, int $id): void
    {
        $species = $this->Species->get(primaryKey: $id, contain: 'Users');

        $this->isAuthorized(entity: $species);

        if ($species->campaign_id !== $campaignId) {
            throw new NotFoundError(message: "Species $id not found");
        }

        if ($this->Species->delete(entity: $species)) {
            $this->output([]);
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new NotFoundError(message: "Specie $id not found");
        }
    }
}
