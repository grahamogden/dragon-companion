<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CharactersSpecies Entity
 *
 * @property int $id
 * @property int $character_id
 * @property int $species_id
 *
 * @property Character $character
 * @property Species $species
 */
class CharactersSpecies extends Entity
{
    public const ENTITY_NAME = 'CharactersSpecies';

    public const FIELD_CHARACTER_ID = 'character_id';
    public const FIELD_SPECIES_ID = 'species_id';

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
        self::FIELD_SPECIES_ID => true,
        'character' => true,
        'species' => true,
    ];
}
