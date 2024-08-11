<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use App\Model\Entity\Item;
use App\Model\Entity\User;
use Authorization\IdentityInterface;

class ItemPolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Item::FUNC_GET_ITEM_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_ITEM_DEFAULT_PERMISSIONS;

    public function canAdd(IdentityInterface|User $identity, Item $item): bool
    {
        return !!$identity->getIdentifier();
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canEdit(IdentityInterface|User $identity, Item $item): bool
    {
        return $this->canWriteForCampaignId(
            identity: $identity,
            campaignId: $item->getCampaignId(),
            entity: $item,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canDelete(IdentityInterface|User $identity, Item $item): bool
    {
        return $this->canDeleteForCampaignId(
            identity: $identity,
            campaignId: $item->getCampaignId(),
            entity: $item,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canView(IdentityInterface|User $identity, Item $item): bool
    {
        return $this->canReadForCampaignId(
            identity: $identity,
            campaignId: $item->getCampaignId(),
            entity: $item,
        );
    }
}
