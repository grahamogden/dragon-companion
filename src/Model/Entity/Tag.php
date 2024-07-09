<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\DateTime;
use Cake\ORM\Entity;

/**
 * Tag Entity
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $tag_name
 * @property string $description
 * @property DateTime $created
 * @property DateTime $modified
 * @property int $user_id
 *
 * @property Campaign $campaign
 * @property User $user
 * @property Role[] $roles
 */
class Tag extends Entity
{
    public const ENTITY_NAME = 'Tags';

    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_TAG_NAME = 'tag_name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_USER_ID = 'user_id';

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
        self::FIELD_CAMPAIGN_ID => true,
        self::FIELD_TAG_NAME => true,
        self::FIELD_DESCRIPTION => true,
        self::FIELD_CREATED => true,
        self::FIELD_MODIFIED => true,
        self::FIELD_USER_ID => true,
        'campaign' => true,
        'user' => true,
        'roles' => true,
    ];
}
