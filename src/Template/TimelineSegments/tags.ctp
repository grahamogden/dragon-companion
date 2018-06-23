<h1>
    Timeline Segments tagged with
    <?= $this->Text->toList(h($tags), 'or') ?>
</h1>

<section>
<?php foreach ($timelineSegments as $timelineSegment): ?>
    <timelineSegment>
        <!-- Use the HtmlHelper to create a link -->
        <h4><?= $this->Html->link(
            $timelineSegment->title,
            ['controller' => 'TimelineSegments', 'action' => 'view', $timelineSegment->slug]
        ) ?></h4>
        <span><?= h($timelineSegment->created) ?>
    </timelineSegment>
<?php endforeach; ?>
</section>