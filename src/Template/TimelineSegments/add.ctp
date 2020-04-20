<?php

use App\Model\Entity\TimelineSegment;
use App\View\AppView;

/**
 * @var AppView $this
 * @var TimelineSegment $timelineSegment
 * @var array $parentTimelineSegments
 * @var array $childTimelineParts
 */

?>
<h1><?= __('Add Timeline Segment') ?></h1>
<div class="timelineSegments form content">
    <?= $this->Form->create($timelineSegment); ?>
    <fieldset>
        <?= $this->Form->control('parent_id', [
            'options' => $parentTimelineSegments,
            'empty'   => true,
            'value'   => $this->request->getParam('id') ?? null, // Automatically fill this value in for the user
            'class'   => ['form-control'],
        ]) ?>
        <?= $this->Form->control('title', ['class'   => ['form-control']]) ?>
        <?= $this->Form->control('body', [
            'type'         => 'textarea-editor',
            'spellcheck'   => 'true',
            'class'   => ['form-control'],
            'templates' => [
                'formGroup' => '<div class="col-12">{{label}}</div><div class="col-12">{{input}}</div>',
            ],
        ]) ?>
<!--         <?= $this->Form->control('tag_string', [
            'label'  => 'Tag',
            'type'   => 'autocomplete',
            'source' => [
                'controller' => 'TimelineSegments',
                'action'     => 'getTags'],
        ]) ?>
        <?= $this->Form->control('non_playable_character_string', [
            'label'  => 'Non-Playable Characters',
            'type'   => 'autocomplete',
            'source' => [
                'controller' => 'TimelineSegments',
                'action'     => 'getNonPlayableCharacters'],
        ]) ?> -->
        <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]); ?>
    </fieldset>
    <?= $this->Form->end(); ?>
</div>
