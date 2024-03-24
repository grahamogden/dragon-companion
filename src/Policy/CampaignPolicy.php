<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Campaign;
use App\Model\Entity\CampaignUser;
use Authentication\IdentityInterface;

/**
 * Campaign policy
 */
class CampaignPolicy
{
    public function canAdd(IdentityInterface $identity, Campaign $campaign): bool
    {
        return !!$identity->getIdentifier();
    }

    public function canEdit(IdentityInterface $identity, Campaign $campaign): bool
    {
        return $this->isCreator($identity, $campaign);
    }

    public function canDelete(IdentityInterface $identity, Campaign $campaign): bool
    {
        return $this->isCreator($identity, $campaign);
    }

    public function canView(IdentityInterface $identity, Campaign $campaign): bool
    {
        return $this->isCreator($identity, $campaign);
    }

    public function isCreator(IdentityInterface $identity, Campaign $campaign): bool
    {
        $userId = $identity->getIdentifier();
        foreach ($campaign->users as $user) {
            /** @var \App\Model\Entity\CampaignUser $campaignUser*/
            $campaignUser = $user->_joinData;
            return $userId === $user->id && $campaignUser->account_level === CampaignUser::ACCOUNT_LEVEL_CREATOR;
        }

        return false;
    }
}
