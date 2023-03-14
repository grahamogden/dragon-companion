<?php

use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;
use App\Model\Entity\TimelineSegment;
use App\View\AppView;

/**
 * @var AppView         $this
 * @var TimelineSegment $timelineSegment
 * @var string          $childTimelineParts
 */
?>
<h1><?= sprintf('%s Timeline Segment (%s)',
    h($timelineSegment->title),
    $this->Html->link(
        __('Edit'),
        [
                'action'     => 'edit',
                'controller' => 'TimelineSegments',
                'id'         => $timelineSegment->id,
        ]
    )
    ); ?></h1>
<div class="timelineSegments view columns content">
    <div class="segment-row show-more-container">
        <div class="show-more-content"><?= dbConverter::fromDatabase($timelineSegment->body); ?></div>
    </div>
    <hr>
    <?php if ($childTimelineParts) { ?>
        <div class="segment-row show-more-container">
            <h2>Child Timeline Segment Synopsis</h2>
            <div class="show-more-content"><?= $childTimelineParts; ?></div>
        </div>
    <?php } // endif; ?>
    <?php if (!empty($timelineSegment->tags)) { ?>
        <div class="segment-row">
            <h2>Tags</h2>
            <ul class="tags-container">
                <?php foreach ($timelineSegment->tags as $tag) { ?>
                    <li class="tag">
                        <?= $this->Html->link($tag->title, [
                            'action'     => 'view',
                            'controller' => 'tags',
                            $tag->id,
                        ], [
                            'target' => '_blank'
                        ]); ?>
                    </li>
                <?php } // endforeach; ?>
            </ul>
        </div>
    <?php } // endif; ?>
    <?php if (!empty($timelineSegment->non_playable_characters)) { ?>
        <div class="segment-row">
            <h2><?= __('Non Playable Characters'); ?></h2>
            <ul class="non-playable-characters-container">
                <?php foreach ($timelineSegment->non_playable_characters as $nonPlayableCharacter) { ?>
                    <li class="non-playable-character">
                        <?= $this->Html->link($nonPlayableCharacter->name, [
                            'action'     => 'view',
                            'controller' => 'NonPlayableCharacter',
                            $nonPlayableCharacter->id,
                        ], [
                            'target' => '_blank'
                        ]); ?>
                    </li>
                <?php } // endforeach; ?>
            </ul>
        </div>
    <?php } // endif; ?>
</div>
<div class="related">
    <h2>Child Timeline Segments</h2>
    <table class="table timeline-segments">
        <tbody>
            <?= $this->element('child-timeline-segment-rows', [
                'childTimelineSegments' => $timelineSegment->child_timeline_segments,
            ]); ?>
            <?= $this->element('add-item-row'); ?>
        </tbody>
    </table>
</div>
