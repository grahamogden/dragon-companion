<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Role;
use App\Model\Entity\Timeline;
use App\Model\Entity\User;
use Authorization\IdentityInterface;

class TimelinePolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Timeline::FUNC_GET_TIMELINE_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_TIMELINE_DEFAULT_PERMISSIONS;

    public function canAdd(IdentityInterface|User $identity, Timeline $timeline): bool
    {
        return !!$identity->getIdentifier();
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canEdit(IdentityInterface|User $identity, Timeline $timeline): bool
    {
        return $this->canWriteForCampaignId(
            identity: $identity,
            campaignId: $timeline->getCampaignId(),
            entity: $timeline,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canDelete(IdentityInterface|User $identity, Timeline $timeline): bool
    {
        return $this->canDeleteForCampaignId(
            identity: $identity,
            campaignId: $timeline->getCampaignId(),
            entity: $timeline,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canView(IdentityInterface|User $identity, Timeline $timeline): bool
    {
        return $this->canReadForCampaignId(
            identity: $identity,
            campaignId: $timeline->getCampaignId(),
            entity: $timeline,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canIndex(IdentityInterface|User $identity, Timeline $timeline): bool
    {
        return $this->canReadForCampaignId(
            identity: $identity,
            campaignId: $timeline->getCampaignId(),
            entity: $timeline,
        );
    }
}
