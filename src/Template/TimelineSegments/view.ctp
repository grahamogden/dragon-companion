<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */
?>
<h1><?= sprintf('%s Timeline Segment (%s)',
    h($timelineSegment->title),
    $this->Html->link(__('Edit'), ['action' => 'edit', $timelineSegment->getId()])
); ?></h1>
<div class="timelineSegments view columns content">
    <!-- <div class="segment-row">
        <h3><?= __('Created'); ?></h3>
        <p class="item"><?= h($timelineSegment->created); ?></p>
    </div> -->
    <div class="segment-row show-more-container">
        <h3><?= __('Body'); ?></h3>
        <div class="show-more-content"><?= $this->Text->autoParagraph($timelineSegment->body); ?></div>
    </div>
    <?php if (!empty($timelineSegment->tags)) { ?>
        <div class="segment-row">
            <h3><?= __('Tags'); ?></h3>
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
</div>
<div class="related">
    <h4><?= __('Child Timeline Segments'); ?></h4>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <!-- <th scope="col"><?= __('Id'); ?></th> -->
            <th scope="col" colspan="2"><?= __('Segments'); ?></th>
            <!-- <th scope="col" class="actions"><?= __('Actions'); ?></th> -->
        </tr>
        <?= $this->element('child-timeline-segment-rows', [
            'childTimelineSegments' => $timelineSegment->child_timeline_segments,
        ]); ?>
        <?= $this->element('add-item-row'); ?>
    </table>
</div>
