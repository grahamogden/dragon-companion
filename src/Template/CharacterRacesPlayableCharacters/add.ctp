<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterRacesPlayableCharacter $characterRacesPlayableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Character Races Playable Characters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Character Races'), ['controller' => 'CharacterRaces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character Race'), ['controller' => 'CharacterRaces', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="characterRacesPlayableCharacters form large-9 medium-8 columns content">
    <?= $this->Form->create($characterRacesPlayableCharacter) ?>
    <fieldset>
        <legend><?= __('Add Character Races Playable Character') ?></legend>
        <?php
            echo $this->Form->control('character_race_id', ['options' => $characterRaces]);
            echo $this->Form->control('playable_character_id', ['options' => $playableCharacters]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
