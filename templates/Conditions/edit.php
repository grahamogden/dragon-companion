<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Condition $condition
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $condition->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $condition->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Conditions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Combat Turns'), ['controller' => 'CombatTurns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Combat Turn'), ['controller' => 'CombatTurns', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="conditions form large-9 medium-8 columns content">
    <?= $this->Form->create($condition) ?>
    <fieldset>
        <legend><?= __('Edit Condition') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
