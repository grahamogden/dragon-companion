<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\DateTime;
use Cake\ORM\Entity;

/**
 * Timeline Entity
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property DateTime $created
 * @property DateTime $modified
 * @property int|null $parent_id
 * @property int $lft
 * @property int $rght
 * @property int $level
 *
 * @property Campaign $campaign
 * @property User $user
 * @property ParentTimeline|Timeline $parent_timeline
 * @property ChildTimeline[]|Timeline[] $child_timelines
 * @property Role[] $roles
 */
class Timeline extends Entity
{
    public const ENTITY_NAME = 'Timelines';

    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_TITLE = 'title';
    public const FIELD_BODY = 'body';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_PARENT_ID = 'parent_id';
    public const FIELD_LFT = 'lft';
    public const FIELD_RGHT = 'rght';
    public const FIELD_LEVEL = 'level';

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
        self::FIELD_TITLE => true,
        self::FIELD_BODY => true,
        self::FIELD_USER_ID => true,
        self::FIELD_CREATED => true,
        self::FIELD_MODIFIED => true,
        self::FIELD_PARENT_ID => true,
        self::FIELD_LFT => true,
        self::FIELD_RGHT => true,
        self::FIELD_LEVEL => true,
        'campaign' => true,
        'user' => true,
        'parent_timeline' => true,
        'child_timelines' => true,
        'roles' => true,
    ];
}