<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */

use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;
?>
<h1>Edit Timeline Segment</h1>
<div class="timelineSegments form large-9 medium-8 columns content">
    <?= $this->Form->create($timelineSegment); ?>
    <fieldset>
        <!-- <legend><?= __('Edit Timeline Segment'); ?></legend> -->
        <?php
            echo $this->Form->control('parent_id', ['options' => $parentTimelineSegments, 'empty' => true]);
            echo $this->Form->control('title');
            // echo $this->Form->control('body');
            echo $this->Form->control('body', [
                'type' => 'textareaeditor',
                'val'  => dbConverter::fromDatabase($timelineSegment->body)
            ]);
            // echo $this->Form->control('tags._ids', ['options' => $tags]);
            // echo $this->Form->input('tags._ids', ['class' => 'autocomplete autocomplete-tags']);
            // echo $this->Form->control('tag_string', ['type' => 'text']);
            echo $this->Form->control('tag_string', [
                'type'   => 'autocomplete',
                'source' => [
                    'controller' => 'TimelineSegments',
                    'action'     => 'getTags'],
                'val' => $timelineSegment->tag_string,
            ]);
            echo $this->Form->control('non_playable_character_string', [
                'type'   => 'autocomplete',
                'source' => [
                    'controller' => 'TimelineSegments',
                    'action'     => 'getNonPlayableCharacters'],
            ]);
        ?>
    </fieldset>
    <?= $this->Form->submit(__('Save')); ?>
    <?= $this->Form->end(); ?>
</div>
