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
        <?php
            echo $this->Form->control('parent_id', [
                'options' => $parentTimelineSegments,
                'empty'   => true,
                'value'   => $this->request->getQuery('parent') ?? null, // Automatically fill this value in for the user
            ]);
            echo $this->Form->control('title');
            echo $this->Form->control('body', [
                'type'         => 'textareaeditor',
                'spellcheck'   => 'true',
            ]);
            echo $this->Form->control('tag_string', [
                'label'  => 'Tag',
                'type'   => 'autocomplete',
                'source' => [
                    'controller' => 'TimelineSegments',
                    'action'     => 'getTags'],
            ]);
            echo $this->Form->control('non_playable_character_string', [
                'label'  => 'Non-Playable Characters',
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
