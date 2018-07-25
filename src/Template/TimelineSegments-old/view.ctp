<h1><?= h($timelineSegment->title) ?></h1>
<p><?= h($timelineSegment->body) ?></p>
<p><small>Created: <?= $timelineSegment->created->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $timelineSegment->slug]) ?></p>