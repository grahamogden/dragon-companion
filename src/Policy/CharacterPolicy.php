<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use App\Model\Entity\Character;

class CharacterPolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Character::FUNC_GET_CHARACTER_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_CHARACTER_DEFAULT_PERMISSIONS;

    // public function canAdd(IdentityInterface|User $identity, Character $character): bool
    // {
    //     return $this->StandardPolicyTrait::canAdd(
    //         identity: $identity,
    //         entity: $character,
    //     );
    //     // return $this->canWriteForCampaignId(
    //     //     identity: $identity,
    //     //     campaignId: $character->getCampaignId(),
    //     //     entity: $character,
    //     // );
    //     // !!$identity->getIdentifier();
    // }

    // /**
    //  * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
    //  */
    // public function canEdit(IdentityInterface|User $identity, Character $item): bool
    // {
    //     return $this->canWriteForCampaignId(
    //         identity: $identity,
    //         campaignId: $item->getCampaignId(),
    //         entity: $item,
    //     );
    // }

    // /**
    //  * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
    //  */
    // public function canDelete(IdentityInterface|User $identity, Character $item): bool
    // {
    //     return $this->canDeleteForCampaignId(
    //         identity: $identity,
    //         campaignId: $item->getCampaignId(),
    //         entity: $item,
    //     );
    // }

    // /**
    //  * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
    //  */
    // public function canView(IdentityInterface|User $identity, Character $item): bool
    // {
    //     return $this->canReadForCampaignId(
    //         identity: $identity,
    //         campaignId: $item->getCampaignId(),
    //         entity: $item,
    //     );
    // }
}
