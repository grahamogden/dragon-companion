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

    // public function canAdd(IdentityInterface|User $identity, Species $species): bool
    // {
    //     return !!$identity->getIdentifier();
    // }

    // /**
    //  * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
    //  */
    // public function canEdit(IdentityInterface|User $identity, Species $species): bool
    // {
    //     return $this->canWriteForCampaignId(
    //         identity: $identity,
    //         campaignId: $species->getCampaignId(),
    //         entity: $species,
    //     );
    // }

    // /**
    //  * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
    //  */
    // public function canDelete(IdentityInterface|User $identity, Species $species): bool
    // {
    //     return $this->canDeleteForCampaignId(
    //         identity: $identity,
    //         campaignId: $species->getCampaignId(),
    //         entity: $species,
    //     );
    // }

    // /**
    //  * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
    //  */
    // public function canView(IdentityInterface|User $identity, Species $species): bool
    // {
    //     return $this->canReadForCampaignId(
    //         identity: $identity,
    //         campaignId: $species->getCampaignId(),
    //         entity: $species,
    //     );
    // }
}
