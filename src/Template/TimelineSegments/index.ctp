<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment[]|\Cake\Collection\CollectionInterface $timelineSegments
 */
?>
<h1><?= __('Timeline Segments') ?></h1>
<?= $this->element('breadcrumbs'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Timeline Segment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="timelineSegments index large-9 medium-8 columns content">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($timelineSegments as $timelineSegment): ?>
            <tr>
                <td><?= $this->Number->format($timelineSegment->id) ?></td>
                <td><?= $timelineSegment->has('parent_timeline_segment') ? $this->Html->link($timelineSegment->parent_timeline_segment->title, ['controller' => 'TimelineSegments', 'action' => 'view', $timelineSegment->parent_timeline_segment->id]) : '' ?></td>
                <td><?= h($timelineSegment->title) ?></td>
                <td><?= h($timelineSegment->created) ?></td>
                <td><?= h($timelineSegment->modified) ?></td>
                <td><?= h($timelineSegment->slug) ?></td>
                <td><?= $timelineSegment->has('user') ? $this->Html->link($timelineSegment->user->id, ['controller' => 'Users', 'action' => 'view', $timelineSegment->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $timelineSegment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $timelineSegment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $timelineSegment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $timelineSegment->id)]) ?>
                    <?= $this->Form->postLink(__('Move down'), [
                        'action' => 'moveDown', $timelineSegment->getId()
                    ], [
                        'confirm' => __('Are you sure you want to move down # {0}?', $timelineSegment->getId())
                    ]) ?>
                    <?= $this->Form->postLink(__('Move up'), [
                        'action' => 'moveUp', $timelineSegment->getId()
                    ], [
                        'confirm' => __('Are you sure you want to move up # {0}?', $timelineSegment->getId())
                    ]) ?>
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
