<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonPlayableCharacter $nonPlayableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Non Playable Characters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="nonPlayableCharacters form large-9 medium-8 columns content">
    <?= $this->Form->create($nonPlayableCharacter) ?>
    <fieldset>
        <legend><?= __('Add Non Playable Character') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('age');
            echo $this->Form->control('appearance');
            echo $this->Form->control('occupation');
            echo $this->Form->control('personality');
            echo $this->Form->control('history');
            echo $this->Form->control('alignment');
            echo $this->Form->control('notes');
            echo $this->Form->control('tag_id', ['options' => $tags, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
