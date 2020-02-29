<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MonsterInstance $monsterInstance
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Monster Instance'), ['action' => 'edit', $monsterInstance->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Monster Instance'), ['action' => 'delete', $monsterInstance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monsterInstance->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Monster Instances'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monster Instance'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monsters'), ['controller' => 'Monsters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monster'), ['controller' => 'Monsters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="monsterInstances view large-9 medium-8 columns content">
    <h3><?= h($monsterInstance->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Monster') ?></th>
            <td><?= $monsterInstance->has('monster') ? $this->Html->link($monsterInstance->monster->name, ['controller' => 'Monsters', 'action' => 'view', $monsterInstance->monster->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($monsterInstance->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($monsterInstance->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Max Hp') ?></th>
            <td><?= $this->Number->format($monsterInstance->max_hp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Current Hp') ?></th>
            <td><?= $this->Number->format($monsterInstance->current_hp) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Participants') ?></h4>
        <?php if (!empty($monsterInstance->participants)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Playable Character Id') ?></th>
                <th scope="col"><?= __('Monster Instance Id') ?></th>
                <th scope="col"><?= __('Order') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($monsterInstance->participants as $participants): ?>
            <tr>
                <td><?= h($participants->id) ?></td>
                <td><?= h($participants->playable_character_id) ?></td>
                <td><?= h($participants->monster_instance_id) ?></td>
                <td><?= h($participants->order) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Participants', 'action' => 'view', $participants->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Participants', 'action' => 'edit', $participants->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Participants', 'action' => 'delete', $participants->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participants->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
