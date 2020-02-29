<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterClass $characterClass
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $characterClass->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $characterClass->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Character Classes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="characterClasses form large-9 medium-8 columns content">
    <?= $this->Form->create($characterClass) ?>
    <fieldset>
        <legend><?= __('Edit Character Class') ?></legend>
        <?php
            echo $this->Form->control('playable_characters._ids', ['options' => $playableCharacters]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
