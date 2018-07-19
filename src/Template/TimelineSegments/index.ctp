<!-- File: src/Template/TimelineSegments/index.ctp -->
<h1>Timeline Segments</h1>
<?php

    $this->Breadcrumbs->add($breadcrumbs);

    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumbs-trail'],
        ['separator' => '']
    );
?>
<table class="insert-table">
    <thead>
        <tr>
            <th colspan="2">
                <?php if($parent) {
                    echo $this->Html->link(
                        $parent->title, [
                            'action' => 'edit',
                            $parent->id
                        ]);
                } else {
                    echo 'Timeline Segments';
                } ?>
            </th>
            <!-- <th class="action-column">Actions</th> -->
        </tr>
    </thead>

    <!-- Here is where we iterate through our $timelineSegments query object, printing out timelineSegment info -->
    <tbody class="sortable">
        <?php
        // If we have a parent, then show the body of it
        if ($parent) {
        ?>
            <tr class="header-row">
                <td colspan="2">
                    <?= __($parent->body) ?>
                </td>
            </tr>
        <?php
        }
        // Set previous ID as 0 because thats what the first item will always have its previous ID set to
        $previousId = 0;
        // Loop through each timeline segment and add a new table row for each record
        foreach ($timelineSegments as $key =>  $timelineSegment) {
            // Add record before current item
            ?>
            <tr class="add-item-row">
                <td colspan="2">
                    <?= $this->Html->link(
                        '&plus;', [
                            'action'      => 'add',
                            'parentId'    => $parent ? $parent->id : 0,
                            // 'previousId'  => $previousId,
                            'nextId'      => $timelineSegment->id,
                        ], [
                            'escapeTitle' => false
                    ]); ?>
                </td>
            </tr>
            <?php // Timeline segment row ?>
            <tr class="item-row">
                <td>
                    <p>
                        <?php
                            echo //sprintf ('%s:%s',
                                $this->Html->link(
                                    $timelineSegment->title, [
                                        'action' => 'index',
                                        'parentId' => $timelineSegment->id,
                                    ]
                                );//,
                                // $this->Html->link(
                                //     $timelineSegment->title, [
                                //         'action' => 'edit',
                                //         $timelineSegment->id
                                //     ])
                            // );
                        ?>
                    </p>
                    <p>
                        <?= __($timelineSegment->body) ?>
                    </p>
                    
                </td>
                <!-- <td> -->
                    <!-- <?= $timelineSegment->created->format('H:i d-m-Y'/*DATE_RFC850*/) ?> -->
                <!-- </td> -->
                <td class="action-column">
                    <?php
                        // Don't show the move up arrow for the first item
                        if ($key > 0) {
                            echo $this->Form->postLink(
                                '', [
                                    'action'    => 'reorder',
                                    'id'        => $previousId,
                                ], [
                                    'class'   => ['action', 'move-arrow', 'arrow-up'],
                            ]);
                        }

                        // If this is the last item, then we don't want to show the move down arrow
                        if ($key < ($timelineSegments->count() - 1)) {
                            echo $this->Form->postLink(
                                '', [
                                    'action'    => 'reorder',
                                    'id'        => $timelineSegment->id,
                                ], [
                                    'class'   => ['action', 'move-arrow', 'arrow-down'],
                            ]);
                        }

                        echo $this->Form->postLink(
                            '', [
                                'action' => 'delete',
                                $timelineSegment->id
                            ], [
                                'class'   => ['action', 'button', 'delete-button'],
                                'confirm' => 'Are you sure you want to delete "' . substr($timelineSegment->title, 0, 20) . '"?'
                        ]);
                    ?>
                </td>
            </tr>
        <?php
            $previousId = $timelineSegment->id;
        }
        // Add row at the bottom after the last timeline segment
        ?>
        <tr class="add-item-row">
            <td colspan="2">
                <?php
                    $options = [
                        'action'   => 'add',
                        'parentId' => $parent ? $parent->id : 0,
                    ];

                    if ($previousId) {
                        $options['previousId'] = $previousId;
                    }

                    echo $this->Html->link('&plus;',
                        $options, [
                            'escapeTitle' => false
                        ]
                    ) ?>
            </td>
        </tr>
    </tbody>
</table>