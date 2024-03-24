<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Participant Entity
 *
 * @property int             $id
 * @property string          $name
 * @property int             $initiative
 * @property int             $combat_encounter_id
 * @property float           $starting_hit_points
 * @property float           $current_hit_points
 * @property int             $armour_class
 * @property int|null        $monster_id
 * @property int|null        $player_character_id
 * @property int             $temporary_id
 * @property CombatEncounter $combat_encounter
 * @property Monster         $monster
 * @property PlayerCharacter $player_character
//  * @property Condition[]     $conditions
 */
class Participant extends Entity
{
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
        'name'                => true,
        'initiative'          => true,
        'combat_encounter_id' => true,
        'starting_hit_points' => true,
        'current_hit_points'  => true,
        'armour_class'        => true,
        'temporary_id'        => true,
        'monster_id'          => true,
        'player_character_id' => true,
        'combat_encounter'    => true,
        'monster'             => true,
        'player_character'    => true,
        // 'conditions'          => true,
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

    public function getStartingHitPoints(): int
    {
        return $this->starting_hit_points;
    }

    public function setStartingHitPoints(int $startingHitPoints): self
    {
        $this->starting_hit_points = $startingHitPoints;

        return $this;
    }

    public function getCurrentHitPoints(): int
    {
        return $this->current_hit_points;
    }

    public function setCurrentHitPoints(int $currentHitPoints): self
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

    public function getMonsterId(): int
    {
        return $this->monster_id;
    }

    public function setMonsterId(int $monsterId): self
    {
        $this->monster_id = $monsterId;

        return $this;
    }

    public function getPlayerCharacterId(): int
    {
        return $this->player_character_id;
    }

    public function setPlayerCharacterId(int $playerCharacterId): self
    {
        $this->player_character_id = $playerCharacterId;

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

    public function getMonster(): Monster
    {
        return $this->monster;
    }

    public function setMonster(Monster $monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    public function getPlayerCharacter(): PlayerCharacter
    {
        return $this->player_character;
    }

    public function setPlayerCharacter(PlayerCharacter $playerCharacter): self
    {
        $this->player_character = $playerCharacter;

        return $this;
    }

    // public function getConditions()
    // {
    //     return $this->conditions;
    // }

    // public function setConditions($conditions): self
    // {
    //     $this->conditions = $conditions;

    //     return $this;
    // }
}
