<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */
?>
<h1><?= h($timelineSegment->title) ?> Timeline Segment</h1>
<?= $this->element('breadcrumbs'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?=
            $this->Html->link(__('Edit Timeline Segment'), [
                'action' => 'edit', $timelineSegment->getId()]
            ) ?></li>
        <li><?=
            $this->Form->postLink(__('Delete Timeline Segment'), [
                'action' => 'delete', $timelineSegment->getId()], [
                    'confirm' => __('Are you sure you want to delete # {0}?', $timelineSegment->getId())]
            ) ?></li>
        <li><?=
            $this->Html->link(__('List Timeline Segments'), [
                'action' => 'index']
            ) ?></li>
        <li><?=
            $this->Html->link(__('New Timeline Segment'), [
                'action' => 'add']
            ) ?></li>
        <li><?=
            $this->Html->link(__('List Parent Timeline Segments'), [
                'controller' => 'TimelineSegments',
                'action' => 'index']
            ) ?></li>
        <li><?=
            $this->Html->link(__('New Parent Timeline Segment'), [
                'controller' => 'TimelineSegments',
                'action' => 'add']
            ) ?></li>
        <li><?=
            $this->Html->link(__('List Users'), [
                'controller' => 'Users',
                'action' => 'index']
            ) ?></li>
        <li><?=
            $this->Html->link(__('New User'), [
                'controller' => 'Users',
                'action' => 'add']
            ) ?></li>
        <li><?=
            $this->Html->link(__('List Child Timeline Segments'), [
                'controller' => 'TimelineSegments',
                'action' => 'index']
            ) ?></li>
        <li><?=
            $this->Html->link(__('New Child Timeline Segment'), [
                'controller' => 'TimelineSegments',
                'action' => 'add']
            ) ?></li>
        <li><?=
            $this->Html->link(__('List Tags'), [
                'controller' => 'Tags',
                'action' => 'index']
            ) ?></li>
        <li><?=
            $this->Html->link(__('New Tag'), [
                'controller' => 'Tags',
                'action' => 'add']
            ) ?></li>
    </ul>
</nav>
<div class="timelineSegments view large-9 medium-8 columns content">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Parent Timeline Segment') ?></th>
            <td><?= $timelineSegment->has('parent_timeline_segment') ? $this->Html->link($timelineSegment->parent_timeline_segment->title, ['controller' => 'TimelineSegments', 'action' => 'view', $timelineSegment->parent_timeline_segment->getId()]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($timelineSegment->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($timelineSegment->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $timelineSegment->has('user') ? $this->Html->link($timelineSegment->user->getId(), ['controller' => 'Users', 'action' => 'view', $timelineSegment->user->getId()]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($timelineSegment->getId()) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($timelineSegment->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($timelineSegment->rght) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($timelineSegment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($timelineSegment->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Body') ?></h4>
        <?= $this->Text->autoParagraph(h($timelineSegment->body)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tags') ?></h4>
        <?php if (!empty($timelineSegment->tags)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($timelineSegment->tags as $tags): ?>
            <tr>
                <td><?= h($tags->getId()) ?></td>
                <td><?= h($tags->title) ?></td>
                <td><?= h($tags->created) ?></td>
                <td><?= h($tags->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tags', 'action' => 'view', $tags->getId()]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tags', 'action' => 'edit', $tags->getId()]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tags', 'action' => 'delete', $tags->getId()], ['confirm' => __('Are you sure you want to delete # {0}?', $tags->getId())]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Timeline Segments') ?></h4>
        <?php if (!empty($timelineSegment->child_timeline_segments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Body') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Slug') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Lft') ?></th>
                <th scope="col"><?= __('Rght') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($timelineSegment->child_timeline_segments as $childTimelineSegments): ?>
            <tr>
                <td><?= h($childTimelineSegments->getId()) ?></td>
                <td><?= h($childTimelineSegments->parent_id) ?></td>
                <td><?= h($childTimelineSegments->title) ?></td>
                <td><?= h($childTimelineSegments->body) ?></td>
                <td><?= h($childTimelineSegments->created) ?></td>
                <td><?= h($childTimelineSegments->modified) ?></td>
                <td><?= h($childTimelineSegments->slug) ?></td>
                <td><?= h($childTimelineSegments->user_id) ?></td>
                <td><?= h($childTimelineSegments->lft) ?></td>
                <td><?= h($childTimelineSegments->rght) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'TimelineSegments', 'action' => 'view', $childTimelineSegments->getId()]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'TimelineSegments', 'action' => 'edit', $childTimelineSegments->getId()]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'TimelineSegments', 'action' => 'delete', $childTimelineSegments->getId()], ['confirm' => __('Are you sure you want to delete # {0}?', $childTimelineSegments->getId())]) ?>
                    <?= $this->Form->postLink(__('Move down'), [
                        'action' => 'moveDown', $childTimelineSegments->getId()
                    ]) ?>
                    <?= $this->Form->postLink(__('Move up'), [
                        'action' => 'moveUp', $childTimelineSegments->getId()
                    ]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
