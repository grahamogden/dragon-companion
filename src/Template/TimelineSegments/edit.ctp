<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */
?>
<h1>Edit Timeline Segment</h1>
<?= $this->element('breadcrumbs'); ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $timelineSegment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $timelineSegment->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Timeline Segments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Parent Timeline Segments'), ['controller' => 'TimelineSegments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Timeline Segment'), ['controller' => 'TimelineSegments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="timelineSegments form large-9 medium-8 columns content">
    <?= $this->Form->create($timelineSegment) ?>
    <fieldset>
        <legend><?= __('Edit Timeline Segment') ?></legend>
        <?php
            echo $this->Form->control('parent_id', ['options' => $parentTimelineSegments, 'empty' => true]);
            echo $this->Form->control('title');
            echo $this->Form->control('body');
            echo $this->Form->control('tags._ids', ['options' => $tags]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
