<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Interface\CampaignChildEntityInterface;
use App\Model\Entity\Interface\EntityInterfaceWithUserIdInterface;
use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $campaign_id
 * @property int $user_id
 *
 * @property Campaign $campaign
 * @property ItemPermission[] $item_permissions
 * @property User $user
 * @property Role[] $roles
 */
class Item extends Entity implements CampaignChildEntityInterface, EntityInterfaceWithUserIdInterface
{
    public const ENTITY_NAME = 'Items';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_ITEM_PERMISSIONS = 'item_permissions';
    public const FIELD_CAMPAIGN = 'campaign';
    public const FIELD_USER = 'user';

    public const FUNC_GET_ITEM_PERMISSIONS = 'getItemPermissions';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        self::FIELD_NAME => true,
        self::FIELD_DESCRIPTION => true,
        self::FIELD_CREATED => false,
        self::FIELD_MODIFIED => false,
        self::FIELD_CAMPAIGN_ID => false,
        self::FIELD_USER_ID => false,
        self::FIELD_ITEM_PERMISSIONS => false,
        self::FIELD_CAMPAIGN => false,
        self::FIELD_USER => false,
    ];

    protected array $_hidden = [
        self::FIELD_CAMPAIGN_ID,
        self::FIELD_USER_ID,
        self::FIELD_ITEM_PERMISSIONS,
    ];

    public function getCampaignId(): int
    {
        return $this->campaign_id;
    }

    /**
     * @return ItemPermission[]
     */
    public function getItemPermissions(): array
    {
        return $this->item_permissions ?? [];
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}
