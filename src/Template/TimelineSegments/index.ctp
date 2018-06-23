<!-- File: src/Template/TimelineSegments/index.ctp -->

<h1>Timeline Segments</h1>
<?= $this->Html->link('Add Timeline Segment', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we iterate through our $timelineSegments query object, printing out timelineSegment info -->

    <?php foreach ($timelineSegments as $timelineSegment): ?>
    <tr>
        <td>
            <?= $this->Html->link($timelineSegment->title, ['action' => 'view', $timelineSegment->slug]) ?>
        </td>
        <td>
            <?= $timelineSegment->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $timelineSegment->slug]) ?>
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $timelineSegment->slug],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>