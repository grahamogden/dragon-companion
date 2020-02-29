<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MonsterInstance[]|\Cake\Collection\CollectionInterface $monsterInstances
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Monster Instance'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Monsters'), ['controller' => 'Monsters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Monster'), ['controller' => 'Monsters', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="monsterInstances index large-9 medium-8 columns content">
    <h3><?= __('Monster Instances') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monster_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('max_hp') ?></th>
                <th scope="col"><?= $this->Paginator->sort('current_hp') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monsterInstances as $monsterInstance): ?>
            <tr>
                <td><?= $this->Number->format($monsterInstance->id) ?></td>
                <td><?= $monsterInstance->has('monster') ? $this->Html->link($monsterInstance->monster->name, ['controller' => 'Monsters', 'action' => 'view', $monsterInstance->monster->id]) : '' ?></td>
                <td><?= h($monsterInstance->name) ?></td>
                <td><?= $this->Number->format($monsterInstance->max_hp) ?></td>
                <td><?= $this->Number->format($monsterInstance->current_hp) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $monsterInstance->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $monsterInstance->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $monsterInstance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monsterInstance->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
