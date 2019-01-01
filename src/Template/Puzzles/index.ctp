<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puzzle[]|\Cake\Collection\CollectionInterface $puzzles
 */
?>
<div class="puzzles index large-9 medium-8 columns content">
    <h3><?= __('Puzzles') ?></h3>
    <?= $this->Html->link(__('New Puzzle'), ['action' => 'add']) ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($puzzles as $puzzle): ?>
            <tr>
                <td><?= $puzzle->has('user') ? $this->Html->link($puzzle->user->id, ['controller' => 'Users', 'action' => 'view', $puzzle->user->id]) : '' ?></td>
                <td><?= h($puzzle->title) ?></td>
                <td><?= h($puzzle->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $puzzle->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $puzzle->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $puzzle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $puzzle->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
    <!-- <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div> -->
</div>
