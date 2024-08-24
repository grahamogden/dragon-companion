<?php

namespace App\Model\Entity;

use App\Model\Entity\Interface\CampaignChildEntityInterface;
use App\Model\Entity\Interface\EntityInterfaceWithUserIdInterface;
use App\Model\Enum\EntityVisibility;
use App\Model\Table\CampaignsTable;
use App\Model\Table\MonsterPermissionsTable;
use App\Model\Table\RolesTable;
use App\Model\Table\UsersTable;
use Cake\ORM\Entity;

/**
 * Monster Entity
 *
 * @property int                  $id
 * @property int                  $campaign_id
 * @property int                  $user_id
 * @property string               $name
 * @property string|null          $description
 * @property int|null             $size
 * @property int|null             $default_hit_points
 * @property int|null             $calculated_hit_points_dice_count
 * @property int|null             $calculated_hit_points_dice_type
 * @property int|null             $calculated_hit_points_modifier
 * @property int|null             $armour_class
 * @property int|null             $speed
 * @property int|null             $challenge_rating
 * @property EntityVisibility     $visibilty
 * @property User                 $user
 * @property MonsterPermission[]  $monster_permissions
 */
class Monster extends Entity implements CampaignChildEntityInterface, EntityInterfaceWithUserIdInterface
{
    public const ENTITY_NAME = 'Monsters';

    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_SIZE = 'size';
    public const FIELD_DEFAULT_HIT_POINTS = 'default_hit_points';
    public const FIELD_CALCULATED_HIT_POINTS_DICE_COUNT = 'calculated_hit_points_dice_count';
    public const FIELD_CALCULATED_HIT_POINTS_DICE_TYPE = 'calculated_hit_points_dice_type';
    public const FIELD_CALCULATED_HIT_POINTS_MODIFIER = 'calculated_hit_points_modifier';
    public const FIELD_ARMOUR_CLASS = 'armour_class';
    public const FIELD_SPEED = 'speed';
    public const FIELD_CHALLENGE_RATING = 'challenge_rating';
    public const FIELD_VISIBILTY = 'visibilty';
    public const FIELD_MONSTER_PERMISSIONS = 'monster_permissions';

    public const FUNC_GET_MONSTER_PERMISSIONS = 'getMonsterPermissions';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        self::FIELD_USER_ID => false,
        self::FIELD_CAMPAIGN_ID => false,
        self::FIELD_NAME => true,
        self::FIELD_DESCRIPTION => true,
        self::FIELD_SIZE => true,
        self::FIELD_DEFAULT_HIT_POINTS => true,
        self::FIELD_CALCULATED_HIT_POINTS_DICE_COUNT => true,
        self::FIELD_CALCULATED_HIT_POINTS_DICE_TYPE => true,
        self::FIELD_CALCULATED_HIT_POINTS_MODIFIER => true,
        self::FIELD_ARMOUR_CLASS => true,
        self::FIELD_SPEED => true,
        self::FIELD_CHALLENGE_RATING => true,
        self::FIELD_VISIBILTY => true,
        self::FIELD_MONSTER_PERMISSIONS => true,
        UsersTable::TABLE_NAME => false,
        CampaignsTable::TABLE_NAME => false,
        RolesTable::TABLE_NAME => false,
        MonsterPermissionsTable::TABLE_NAME => false,
    ];

    protected array $_hidden = [
        self::FIELD_CAMPAIGN_ID,
        self::FIELD_USER_ID,
        self::FIELD_MONSTER_PERMISSIONS,
        self::FIELD_VISIBILTY,
        '_matchingData',
    ];

    public function getCampaignId(): int
    {
        return $this->campaign_id;
    }

    /**
     * @return MonsterPermission[]
     */
    public function getMonsterPermissions(): array
    {
        return $this->monster_permissions ?? [];
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}
