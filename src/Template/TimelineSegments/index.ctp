<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment[]|\Cake\Collection\CollectionInterface $timelineSegments
 */
?>
<h1><?= __('Timeline Segments') ?></h1>
<div class="timelineSegments index large-9 medium-8 columns content">
    <table cellpadding="0" cellspacing="0">
        <tbody>
            <?= $this->element('child-timeline-segment-rows'); ?>
            <?= $this->element('add-item-row'); ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
</div>
