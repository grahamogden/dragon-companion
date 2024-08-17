<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Campaign;
use App\Model\Entity\Role;
use App\Model\Entity\User;
use Authorization\IdentityInterface;

class CampaignPolicy
{
    use StandardPolicyTrait;

    private string $overridePermissionsTableName = Campaign::FUNC_GET_CAMPAIGN_PERMISSIONS;
    private string $defaultPermissionsFieldName = Role::ACCESSOR_NAME_CAMPAIGN_DEFAULT_PERMISSIONS;

    public function canAdd(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        // So long as the user is logged in then they can create campaigns!
        return !!$identity->getIdentifier();
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canEdit(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        return $this->canWriteForCampaignId(
            identity: $identity,
            campaignId: $campaign->getId(),
            entity: $campaign,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canDelete(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        return $this->canDeleteForCampaignId(
            identity: $identity,
            campaignId: $campaign->getId(),
            entity: $campaign,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canView(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        return $this->canReadForCampaignId(
            identity: $identity,
            campaignId: $campaign->getId(),
            entity: $campaign,
        );
    }

    /**
     * @codeCoverageIgnore - is covered by StandardPolicyTraitTest
     */
    public function canIndex(IdentityInterface|User $identity, Campaign $campaign): bool
    {
        return $this->canReadForCampaignId(
            identity: $identity,
            campaignId: $campaign->getId(),
            entity: $campaign,
        );
    }
}
