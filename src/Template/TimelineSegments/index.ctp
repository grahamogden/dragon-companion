<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment[]|\Cake\Collection\CollectionInterface $timelineSegments
 */
?>
<h1><?= __('Campaigns') ?></h1>
<div class="timelineSegments index content">
    <p>Welcome to Campaigns! From here, you can create a new campaign and fill it with all of the timeline segments that make it up. </p>
    <table class="table table-hover timeline-segments">
        <tbody>
            <?= $this->element('child-timeline-segment-rows'); ?>
            <?= $this->element('add-item-row'); ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
</div>
