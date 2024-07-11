<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Interface\CampaignChildEntityInterface;
use Cake\ORM\Entity;

/**
 * Species Entity
 *
 * @property int $id
 * @property string $name
 * @property int $campaign_id
 * @property int $user_id
 *
 * @property Campaign $campaign
 * @property SpeciesPermission[] $species_permissions
 * @property User $user
 * @property Character[] $characters
 * @property Role[] $roles
 */
class Species extends Entity implements CampaignChildEntityInterface
{
    public const ENTITY_NAME = 'Species';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_SPECIES_PERMISSIONS = 'species_permissions';
    public const FIELD_CAMPAIGN = 'campaign';
    public const FIELD_USER = 'user';
    public const FIELD_CHARACTERS = 'characters';

    public const FUNC_GET_SPECIES_PERMISSIONS = 'getSpeciesPermissions';

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
        self::FIELD_CAMPAIGN_ID => true,
        self::FIELD_USER_ID => true,
        self::FIELD_SPECIES_PERMISSIONS => true,
        self::FIELD_CAMPAIGN => true,
        self::FIELD_USER => true,
        self::FIELD_CHARACTERS => true,
    ];

    protected array $_hidden = [
        self::FIELD_CAMPAIGN_ID,
        self::FIELD_USER_ID,
        self::FIELD_SPECIES_PERMISSIONS,
    ];

    public function getCampaignId(): int
    {
        return $this->campaign_id;
    }

    /**
     * @return SpeciesPermission[]
     */
    public function getSpeciesPermissions(): array
    {
        return $this->species_permissions ?? [];
    }
}
