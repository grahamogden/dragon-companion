<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampaignUser Entity
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $user_id
 * @property int $member_status
 * @property int $account_level
 *
 * @property \App\Model\Entity\Campaign $campaign
 * @property \App\Model\Entity\User $user
 */
class CampaignUser extends Entity
{
    public const ACCOUNT_LEVEL_USER    = 1;
    public const ACCOUNT_LEVEL_ADMIN   = 10;
    public const ACCOUNT_LEVEL_CREATOR = 20;

    public const MEMBER_STATUS_ACTIVE  = 1;
    public const MEMBER_STATUS_PENDING = 5;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'campaign_id' => true,
        'user_id' => true,
        'member_status' => true,
        'account_level' => true,
        'campaign' => true,
        'user' => true,
    ];
}
