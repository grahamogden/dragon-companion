<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment[]|\Cake\Collection\CollectionInterface $timelineSegments
 */
?>
<h1><?= __('Timeline Segments') ?></h1>
<div class="timelineSegments index content">
    <p>These are the timeline segments that make up your campaign! You can add timeline segments within timeline segments, so you can start off really broad with high-level ideas and then break them down into smaller pieces within them!</p>
    <table class="table timeline-segments">
        <tbody>
            <?= $this->element('child-timeline-segment-rows'); ?>
            <?= $this->element('add-item-row'); ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
</div>
