<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlayableCharacter $playableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Character Classes'), ['controller' => 'CharacterClasses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character Class'), ['controller' => 'CharacterClasses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Character Races'), ['controller' => 'CharacterRaces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character Race'), ['controller' => 'CharacterRaces', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="playableCharacters form large-9 medium-8 columns content">
    <?= $this->Form->create($playableCharacter) ?>
    <fieldset>
        <legend><?= __('Add Playable Character') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('age');
            echo $this->Form->control('max_hp');
            echo $this->Form->control('current_hp');
            echo $this->Form->control('armour_class');
            echo $this->Form->control('character_classes._ids', ['options' => $characterClasses]);
            echo $this->Form->control('character_races._ids', ['options' => $characterRaces]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
