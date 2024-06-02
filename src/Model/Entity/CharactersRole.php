<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CharactersRole Entity
 *
 * @property int $id
 * @property int $character_id
 * @property int $role_id
 *
 * @property Character $character
 * @property Role $role
 */
class CharactersRole extends Entity
{
    public const ENTITY_NAME = 'CharactersRoles';

    public const FIELD_ROLE_ID = 'role_id';
    public const FIELD_CHARACTER_ID = 'character_id';

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
        self::FIELD_CHARACTER_ID => true,
        self::FIELD_ROLE_ID => true,
        'character' => true,
        'role' => true,
    ];
}
