<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CombatEncounter $combatEncounter
 */

/*
 * COMBAT ENCOUNTERS
 * 
 * Combat is made up of two parts:
 * - Initiative
 * - Looping rounds of combat
 * 
 * Initiative
 * All playable characters and monsters roll and include their speed to provide them with a
 * number that represents their _order in combat_, known as initiative.
 *
 * Combat
 * This is a loop of rounds, each round being comprised of each character having the opportunity
 * for combat - meaning a character could wait until later in the round or completely skip the round entirely
 *
 * Turns Combat
 * A turn in combat is made up of a few different components, here are a few of them:
 * - Action
 *   = Attack - one source attacks a single or multiple targets
 *   = Heal - one source replenishes the health of a single or multiple targets
 *   = Opportunity Attacks - when one source attacks a target or moves away from a target,
 *   the target may have the opportunity to attack the source
 * - Movement
 * - Bonus action
 * - Reaction (although not necessarily during your turn) - such as opportunity attacks
 *
 * There are plenty of additional things that can be done during a turn of combat, but let us
 * focus on delivering specific things, one at a time!
 * - 
 */

echo $this->Html->script('combat-encounters.js');
?>
<div class="combatEncounters form content">
    <h1>Add Combat Encounter</h1>
    <?= $this->Form->create($combatEncounter) ?>
        <fieldset>
            <?= $this->Form->control('name', ['class' => ['form-control']]) ?>
            <?= $this->Form->textarea('json', ['class' => ['form-control'], 'readonly']) ?>
        </fieldset>
        <?= $this->Form->submit('Save Encounter', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
