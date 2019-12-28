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
        <?= $this->Form->control('parent_id', [
            'options' => $parentTimelineSegments,
            'empty' => true
        ]) ?>
        <?= $this->Form->control('title') ?>
        <?= $this->Form->control('tag_string', [
            'label'  => 'Tag',
            'type'   => 'autocomplete',
            'source' => [
                'controller' => 'TimelineSegments',
                'action'     => 'getTags'],
            'val'        => $timelineSegment->tag_string,
            'spellcheck' => 'true',
        ]) ?>
        <?= $this->Form->control('non_playable_character_string', [
            'label'  => 'Non-Playable Characters',
            'type'   => 'autocomplete',
            'source' => [
                'controller' => 'TimelineSegments',
                'action'     => 'getNonPlayableCharacters'],
            'val'        => $timelineSegment->non_playable_character_string,
            'spellcheck' => 'true',
        ]) ?>
        <?= $this->Form->control('body', [
            'type'         => 'textareaeditor',
            'val'          => dbConverter::fromDatabase($timelineSegment->getBody()),
            'spellcheck'   => 'true',
            'id'   => $timelineSegment->getId(),
        ]) ?>
        <div class="segment-row">
            <h3><?= __('Child Timeline Segment Synopsis'); ?></h3>
            <div><?= $childTimelineParts; ?></div>
        </div>
    </fieldset>
    <?= $this->Form->submit(__('Save')); ?>
    <?= $this->Form->end(); ?>
</div>
