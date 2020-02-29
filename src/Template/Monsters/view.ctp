<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monster $monster
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Monster'), ['action' => 'edit', $monster->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Monster'), ['action' => 'delete', $monster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monster->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Monsters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monster'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monster Instances'), ['controller' => 'MonsterInstances', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monster Instance'), ['controller' => 'MonsterInstances', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="monsters view large-9 medium-8 columns content">
    <h3><?= h($monster->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($monster->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($monster->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Monster Instances') ?></h4>
        <?php if (!empty($monster->monster_instances)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Monster Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Max Hp') ?></th>
                <th scope="col"><?= __('Current Hp') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($monster->monster_instances as $monsterInstances): ?>
            <tr>
                <td><?= h($monsterInstances->id) ?></td>
                <td><?= h($monsterInstances->monster_id) ?></td>
                <td><?= h($monsterInstances->name) ?></td>
                <td><?= h($monsterInstances->max_hp) ?></td>
                <td><?= h($monsterInstances->current_hp) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MonsterInstances', 'action' => 'view', $monsterInstances->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MonsterInstances', 'action' => 'edit', $monsterInstances->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MonsterInstances', 'action' => 'delete', $monsterInstances->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monsterInstances->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
