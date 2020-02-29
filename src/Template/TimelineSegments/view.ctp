<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */

use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;
?>
<h1><?= sprintf('%s Timeline Segment (%s)',
    h($timelineSegment->title),
    $this->Html->link('Edit', ['action' => 'edit', $timelineSegment->getId()])
); ?></h1>
<div class="timelineSegments view columns content">
    <div class="segment-row show-more-container">
        <div class="show-more-content"><?= dbConverter::fromDatabase($this->Text->autoParagraph($timelineSegment->body)); ?></div>
    </div>
    <hr>
    <div class="segment-row show-more-container">
        <h3>Child Timeline Segment Synopsis</h3>
        <div class="show-more-content"><?= $childTimelineParts; ?></div>
    </div>
    <?php if (!empty($timelineSegment->tags)) { ?>
        <div class="segment-row">
            <h3>Tags</h3>
            <div class="tags-container">
                <?php foreach ($timelineSegment->tags as $tags) { ?>
                    <div class="tag">
                        <?= $this->Form->postLink($tags->title, [
                            'action' => 'removeTag',
                        ], [
                            'confirm' => 'Are you sure you want to remove this tag?',
                        ]); ?>
                    </div>
                <?php } // endforeach; ?>
            </div>
        </div>
    <?php } // endif; ?>
    <?php if (!empty($timelineSegment->non_playable_characters)) { ?>
        <div class="segment-row">
            <h3><?= __('Non Playable Characters'); ?></h3>
            <ul class="non-playable-characters-container">
                <?php foreach ($timelineSegment->non_playable_characters as $nonPlayableCharacters) { ?>
                    <li class="non-playable-character">
                        <?= $this->Form->postLink($nonPlayableCharacters->name, [
                            'action' => 'removeNonPlayableCharacter',
                        ], [
                            'confirm' => 'Are you sure you want to remove this NPC?',
                        ]); ?>
                    </li>
                <?php } // endforeach; ?>
            </ul>
        </div>
    <?php } // endif; ?>
</div>
<div class="related">
    <h4>Child Timeline Segments</h4>
    <table class="table table-hover timeline-segments">
        <tbody>
            <?= $this->element('child-timeline-segment-rows', [
                'childTimelineSegments' => $timelineSegment->child_timeline_segments,
            ]); ?>
            <?= $this->element('add-item-row'); ?>
        </tbody>
    </table>
</div>
