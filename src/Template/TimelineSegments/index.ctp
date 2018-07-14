<!-- File: src/Template/TimelineSegments/index.ctp -->

<h1>Timeline Segments</h1>
<?php

    $this->Breadcrumbs->add($breadcrumbs);

    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumbs-trail'],
        ['separator' => '']
    );

    echo $this->Html->link('Add Timeline Segment', ['action' => 'add']);
?>
<table class="insert-table">
    <thead>
        <tr>
            <th>Synopsis</th>
            <th>Action</th>
        </tr>
    </thead>

    <!-- Here is where we iterate through our $timelineSegments query object, printing out timelineSegment info -->
    <tbody>
        <?php foreach ($timelineSegments as $timelineSegment): ?>
        <tr>
            <td>
                <?= $this->Html->link(
                    $timelineSegment->id,
                    [
                        'action' => 'index',
                        'parentId' => $timelineSegment->id,
                    ]
                ); ?>:
                <?= $this->Html->link(
                    $timelineSegment->title,
                    [
                        'action' => 'edit',
                        $timelineSegment->id
                    ]);
                ?>
            </td>
            <!-- <td> -->
                <!-- <?= $timelineSegment->created->format('H:i d-m-Y'/*DATE_RFC850*/) ?> -->
            <!-- </td> -->
            <td>
                <?= $this->Html->link(
                    'Edit',
                    [
                        'action' => 'edit',
                        $timelineSegment->id
                    ]
                ) ?>
                <?= $this->Form->postLink(
                    'Delete',
                    [
                        'action' => 'delete',
                        $timelineSegment->id
                    ],
                    [
                        'class' => [CSS_CLASS_RED_ITEM],
                        'confirm' => 'Are you sure?'
                    ])
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>