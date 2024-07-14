<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use App\Model\Entity\Species;
use App\Model\Entity\User;
use Authorization\IdentityInterface;

class SpeciesPolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Species::FUNC_GET_SPECIES_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_SPECIES_DEFAULT_PERMISSIONS;

    public function canAdd(IdentityInterface|User $identity, Species $species): bool
    {
        return !!$identity->getIdentifier();
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canEdit(IdentityInterface|User $identity, Species $species): bool
    {
        return $this->canWriteForCampaignId(
            identity: $identity,
            campaignId: $species->getCampaignId(),
            entity: $species,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canDelete(IdentityInterface|User $identity, Species $species): bool
    {
        return $this->canDeleteForCampaignId(
            identity: $identity,
            campaignId: $species->getCampaignId(),
            entity: $species,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canView(IdentityInterface|User $identity, Species $species): bool
    {
        return $this->canReadForCampaignId(
            identity: $identity,
            campaignId: $species->getCampaignId(),
            entity: $species,
        );
    }

    // public function canEdit(IdentityInterface|User $identity, Species $species): bool
    // {
    //     if ($this->isCreator(identity: $identity, species: $species)) {
    //         return true;
    //     }

    //     $userRole = $this->getUserRoleForSpecies(identity: $identity, species: $species);

    //     if (null === $userRole) {
    //         return false;
    //     }

    //     /** @var SpeciesPermission $permission */
    //     foreach ($species->species_permissions as $permissions) {
    //         if ($permissions->getRoleId() === $userRole->getId()) {
    //             return $permission->canWrite();
    //         }
    //     }
    //     return false;
    // }

    // public function canDelete(IdentityInterface|User $identity, Species $species): bool
    // {
    //     if ($this->isCreator(identity: $identity, species: $species)) {
    //         return true;
    //     }

    //     $userRole = $this->getUserRoleForSpecies(identity: $identity, species: $species);

    //     if (null === $userRole) {
    //         return false;
    //     }

    //     /** @var SpeciesPermission $permission */
    //     foreach ($species->species_permissions as $permissions) {
    //         if ($permissions->getRoleId() === $userRole->getId()) {
    //             return $permission->canDelete();
    //         }
    //     }

    //     return false;
    // }

    // public function canView(IdentityInterface|User $identity, Species $species): bool
    // {
    //     if ($this->isCreator(identity: $identity, species: $species)) {
    //         return true;
    //     }

    //     $userRole = $this->getUserRoleForSpecies(identity: $identity, species: $species);

    //     if (null === $userRole) {
    //         return false;
    //     }

    //     /** @var SpeciesPermission $permission */
    //     foreach ($species->species_permissions as $permissions) {
    //         if ($permissions->getRoleId() === $userRole->getId()) {
    //             return $permission->canRead();
    //         }
    //     }
    //     return false;
    // }

    // public function canIndex(IdentityInterface|User $identity, Species $species): bool
    // {
    //     if ($this->isCreator(identity: $identity, species: $species)) {
    //         return true;
    //     }

    //     $userRole = $this->getUserRoleForSpecies(identity: $identity, species: $species);

    //     // if (null === $userRole) {
    //     //     return false;
    //     // }

    //     /** @var SpeciesPermission $permission */
    //     foreach ($species->species_permissions as $permissions) {
    //         if ($permissions->getRoleId() === $userRole->getId()) {
    //             return $permission->canRead();
    //         }
    //     }

    //     return false;
    // }

    // private function getUserRoleForSpecies(IdentityInterface|User $identity, Species $species): ?Role
    // {
    //     foreach ($identity->getRoles() as $role) {
    //         if ($role->species_id === $species->id) {
    //             return $role;
    //         }
    //     }

    //     return null;
    // }

    // private function isCreator(IdentityInterface|User $identity, Species $species): bool
    // {
    //     return $species->user_id === $identity->getIdentifier();
    // }
}
