<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterClassesPlayableCharacter $characterClassesPlayableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Character Classes Playable Characters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Character Classes'), ['controller' => 'CharacterClasses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character Class'), ['controller' => 'CharacterClasses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="characterClassesPlayableCharacters form large-9 medium-8 columns content">
    <?= $this->Form->create($characterClassesPlayableCharacter) ?>
    <fieldset>
        <legend><?= __('Add Character Classes Playable Character') ?></legend>
        <?php
            echo $this->Form->control('character_class_id', ['options' => $characterClasses]);
            echo $this->Form->control('player_character_id', ['options' => $playableCharacters]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
