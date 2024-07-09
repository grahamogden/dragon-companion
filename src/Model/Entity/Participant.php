<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Participant Entity
 *
 * @property int $id
 * @property int $combat_encounter_id
 * @property int|null $character_id
 * @property string $name
 * @property int $initiative
 * @property float $starting_hit_points
 * @property float $current_hit_points
 * @property int $armour_class
 * @property int $temporary_id
 *
 * @property CombatEncounter $combat_encounter
 * @property Character $character
 */
class Participant extends Entity
{
    public const ENTITY_NAME = 'Participants';

    public const FIELD_COMBAT_ENCOUNTER_ID = 'combat_encounter_id';
    public const FIELD_CHARACTER_ID = 'character_id';
    public const FIELD_NAME = 'name';
    public const FIELD_INITIATIVE = 'initiative';
    public const FIELD_STARTING_HIT_POINTS = 'starting_hit_points';
    public const FIELD_CURRENT_HIT_POINTS = 'current_hit_points';
    public const FIELD_ARMOUR_CLASS = 'armour_class';
    public const FIELD_TEMPORARY_ID = 'temporary_id';
    public const FIELD_COMBAT_ENCOUNTER = 'combat_encounter';

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
        self::FIELD_COMBAT_ENCOUNTER_ID => true,
        self::FIELD_CHARACTER_ID => true,
        self::FIELD_NAME => true,
        self::FIELD_INITIATIVE => true,
        self::FIELD_STARTING_HIT_POINTS => true,
        self::FIELD_CURRENT_HIT_POINTS => true,
        self::FIELD_ARMOUR_CLASS => true,
        self::FIELD_TEMPORARY_ID => true,
        self::FIELD_COMBAT_ENCOUNTER => true,
        'character' => true,
    ];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInitiative(): int
    {
        return $this->initiative;
    }

    public function setInitiative(int $initiative): self
    {
        $this->initiative = $initiative;

        return $this;
    }

    public function getCombatEncounterId(): int
    {
        return $this->combat_encounter_id;
    }

    public function setCombatEncounterId(int $combatEncounterId): self
    {
        $this->combat_encounter_id = $combatEncounterId;

        return $this;
    }

    public function getStartingHitPoints(): float
    {
        return $this->starting_hit_points;
    }

    public function setStartingHitPoints(float $startingHitPoints): self
    {
        $this->starting_hit_points = $startingHitPoints;

        return $this;
    }

    public function getCurrentHitPoints(): float
    {
        return $this->current_hit_points;
    }

    public function setCurrentHitPoints(float $currentHitPoints): self
    {
        $this->current_hit_points = $currentHitPoints;

        return $this;
    }

    public function getArmourClass(): int
    {
        return $this->armour_class;
    }

    public function setArmourClass(int $armourClass): self
    {
        $this->armour_class = $armourClass;

        return $this;
    }

    public function getTemporaryId(): int
    {
        return $this->temporary_id;
    }

    public function setTemporaryId(int $temporaryId): self
    {
        $this->temporary_id = $temporaryId;

        return $this;
    }
    public function getCombatEncounter(): CombatEncounter
    {
        return $this->combat_encounter;
    }

    public function setCombatEncounter(CombatEncounter $combatEncounter): self
    {
        $this->combat_encounter = $combatEncounter;

        return $this;
    }

    public function getCharacter()
    {
        return $this->character;
    }

    public function setCharacter($character): self
    {
        $this->character = $character;

        return $this;
    }

    // public function getMonsterId(): int
    // {
    //     return $this->monster_id;
    // }

    // public function setMonsterId(int $monsterId): self
    // {
    //     $this->monster_id = $monsterId;

    //     return $this;
    // }

    // public function getPlayerCharacterId(): int
    // {
    //     return $this->player_character_id;
    // }

    // public function setPlayerCharacterId(int $playerCharacterId): self
    // {
    //     $this->player_character_id = $playerCharacterId;

    //     return $this;
    // }

    // public function getMonster()
    // {
    //     return $this->character;
    // }

    // public function setMonster($character): self
    // {
    //     $this->character = $character;

    //     return $this;
    // }

    // public function getPlayerCharacter()
    // {
    //     return $this->character;
    // }

    // public function setPlayerCharacter($character): self
    // {
    //     $this->character = $character;

    //     return $this;
    // }
}
