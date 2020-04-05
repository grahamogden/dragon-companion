<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monster[]|\Cake\Collection\CollectionInterface $monsters
 */
?>
<div class="monsters index content">
    <h1><?= __('Monsters') ?></h1>
    <div class="form-group">
        <?= $this->Html->link(
            __('New Monster Instance'),
            [
                'action' => 'add'
            ],
            [
                'class' => [
                    'btn',
                    'btn-outline-success'
                ]
            ]
        ) ?>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monsters as $monster): ?>
            <tr>
                <td><?= $this->Number->format($monster->id) ?></td>
                <td><?= h($monster->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $monster->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $monster->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $monster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $monster->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
