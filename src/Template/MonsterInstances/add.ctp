<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MonsterInstance $monsterInstance
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Monster Instances'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Monsters'), ['controller' => 'Monsters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Monster'), ['controller' => 'Monsters', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="monsterInstances form large-9 medium-8 columns content">
    <?= $this->Form->create($monsterInstance) ?>
    <fieldset>
        <legend><?= __('Add Monster Instance') ?></legend>
        <?php
            echo $this->Form->control('monster_id', ['options' => $monsters, 'empty' => true]);
            echo $this->Form->control('name');
            echo $this->Form->control('max_hp');
            echo $this->Form->control('current_hp');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
