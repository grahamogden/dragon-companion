<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */
?>
<h1>Edit Timeline Segment</h1>
<div class="timelineSegments form large-9 medium-8 columns content">
    <?= $this->Form->create($timelineSegment); ?>
    <fieldset>
        <!-- <legend><?= __('Edit Timeline Segment'); ?></legend> -->
        <?php
            echo $this->Form->control('parent_id', ['options' => $parentTimelineSegments, 'empty' => true]);
            echo $this->Form->control('title');
            echo $this->Form->control('body');
            echo $this->Form->control('tags._ids', ['options' => $tags]);
        ?>
    </fieldset>
    <?= $this->Form->submit(__('Save')); ?>
    <?= $this->Form->end(); ?>
</div>