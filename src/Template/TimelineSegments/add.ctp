<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */
?>
<h1>Add Timeline Segment</h1>
<div class="timelineSegments form large-9 medium-8 columns content">
    <?= $this->Form->create($timelineSegment); ?>
    <fieldset>
        <!-- <legend><?= __('Add Timeline Segment'); ?></legend> -->
        <?php
            echo $this->Form->hidden('parent_id', [
                'value'   => $this->request->getQuery('parent') ?? null,
            ]);
            echo $this->Form->control('title');
            echo $this->Form->control('body', ['rows' => '7']);
            echo $this->Form->control('tags._ids', ['options' => $tags]);
        ?>
    </fieldset>
    <?= $this->Form->submit(__('Save')); ?>
    <?= $this->Form->end(); ?>
</div>
