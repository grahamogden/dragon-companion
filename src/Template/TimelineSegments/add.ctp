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
            echo $this->Form->control('parent_id', [
                'options' => $parentTimelineSegments,
                'empty' => true,
                'value'   => $this->request->getQuery('parent') ?? null,
            ]);
            echo $this->Form->control('title');
            // echo $this->Form->control('body', ['rows' => '7']);
            echo $this->Form->control('body', [
                'type' => 'textareaeditor',
            ]);
            echo $this->Form->control('tag_string', [
                'type'   => 'autocomplete',
                'source' => [
                    'controller' => 'TimelineSegments',
                    'action'     => 'getTags'],
            ]);
        ?>
    </fieldset>
    <?= $this->Form->submit(__('Save')); ?>
    <?= $this->Form->end(); ?>
</div>
