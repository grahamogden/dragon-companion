<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterRace $characterRace
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Character Races'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="characterRaces form large-9 medium-8 columns content">
    <?= $this->Form->create($characterRace) ?>
    <fieldset>
        <legend><?= __('Add Character Race') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('playable_characters._ids', ['options' => $playableCharacters]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
