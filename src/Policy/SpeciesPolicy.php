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
}
