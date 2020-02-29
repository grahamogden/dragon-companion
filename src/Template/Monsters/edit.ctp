<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monster $monster
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $monster->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $monster->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Monsters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Monster Instances'), ['controller' => 'MonsterInstances', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Monster Instance'), ['controller' => 'MonsterInstances', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="monsters form large-9 medium-8 columns content">
    <?= $this->Form->create($monster) ?>
    <fieldset>
        <legend><?= __('Edit Monster') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
