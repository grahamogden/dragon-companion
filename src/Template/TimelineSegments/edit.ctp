<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */

use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;
?>
<h1>Edit Timeline Segment</h1>
<div class="timelineSegments form content">
    <?= $this->Form->create($timelineSegment); ?>
    <fieldset>
        <?= $this->Form->control('parent_id', [
            'options' => $parentTimelineSegments,
            'empty'   => true,
            'class'   => ['form-control'],
        ]) ?>
        <?= $this->Form->control('title', ['class' => ['form-control']]) ?>
<!--         <?= $this->Form->control('tag_string', [
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
        ]) ?> -->
        <?= $this->Form->control('body', [
            'type'         => 'textareaeditor',
            'val'          => dbConverter::fromDatabase($timelineSegment->getBody()),
            'spellcheck'   => 'true',
            'id'           => $timelineSegment->getId(),
            'class'        => ['form-control'],
        ]) ?>
        <div class="segment-row">
            <h3>Child Timeline Segment Synopsis</h3>
            <div><?= $childTimelineParts; ?></div>
        </div>
        <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]); ?>
    </fieldset>
    <?= $this->Form->end(); ?>
</div>
