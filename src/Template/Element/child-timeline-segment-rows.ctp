<?php
use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;

$childCounter = 0;
foreach ($childTimelineSegments as $childTimelineSegment) {
    $childCounter++;
    ?>
    <tr>
        <th class="align-items-center d-flex bg-light">
            <?= $this->Html->link($childTimelineSegment->title, [
                'action' => 'view',
                $childTimelineSegment->id,
            ]); ?>
            <div class="dropdown d-inline-block ml-auto">
                <button class="btn btn-secondary dropdown-toggle shadow-none" type="button" id="timelineDropdownMenuButton<?=$childCounter?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                <div class="dropdown-menu dropdown-menu-right flex-column" aria-labelledby="timelineDropdownMenuButton<?=$childCounter?>">
                    <?php if ($childCounter > 1) { ?>
                        <?php // Move to top ?>
                        <?= $this->Form->postLink('Move to top', [
                            'action' => 'moveUpTop',
                            $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-2'
                            ],
                            'role' => 'button',
                        ]); ?>

                        <?php // Move up ?>
                        <?= $this->Form->postLink('Move up', [
                            'action' => 'moveUp',
                            $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-2'
                            ],
                            'role' => 'button',
                        ]); ?>
                    <?php } ?>

                    <?php if (/*$childCounter > 1 &&*/ $childCounter < count($childTimelineSegments)) { ?>
                        <?php // Move down ?>
                        <?= $this->Form->postLink('Move down', [
                            'action' => 'moveDown',
                            $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-2'
                            ],
                            'role' => 'button',
                        ]); ?>

                        <?php // Move to bottom ?>
                        <?= $this->Form->postLink('Move to bottom', [
                            'action' => 'moveDownBottom',
                            $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-2'
                            ],
                            'role' => 'button',
                        ]); ?>
                    <?php } ?>

                    <?= $this->Html->link('Edit', [
                        'action' => 'edit',
                        $childTimelineSegment->id
                    ], [
                        'class'   => [
                            'btn',
                            'btn-primary',
                            'mb-2'
                        ],
                        'role' => 'button',
                    ]); ?>

                    <?= $this->Form->postLink('Delete', [
                        'action' => 'delete',
                        $childTimelineSegment->id
                    ], [
                        'class'   => [
                            'btn',
                            'btn-danger',
                        ],
                        'role' => 'button',
                        'confirm' => __('Are you sure you want to delete # {0}?', $childTimelineSegment->id),
                    ]); ?>
                </div>
            </div>
        </th>
    </tr>
    <tr>
        <td class="show-more-container">
            <div class="show-more-content"><?= dbConverter::fromDatabase($this->Text->autoParagraph($childTimelineSegment->body)); ?></div>
        </td>
    </tr>
<?php } // endforeach; ?>



<?php
/*
                <ul class="menu">
                    <?php
                        if ($childCounter > 1) {
                            // Move to top
                            echo sprintf('<li>%s</li>',
                                $this->Form->postLink('', [
                                        'action' => 'moveUpTop',
                                        $childTimelineSegment->id,
                                    ], [
                                        'class' => [
                                            'action',
                                            'move-arrow',
                                            'arrow-up',
                                            'top',
                                            'btn-info',
                                        ],
                            ]));
                            // Move up
                            echo sprintf('<li>%s</li>',
                                $this->Form->postLink('', [
                                        'action' => 'moveUp',
                                        $childTimelineSegment->id,
                                    ], [
                                        'class' => [
                                            'action',
                                            'move-arrow',
                                            'arrow-up',
                                            'btn-info',
                                        ],
                            ]));
                        }

                        if ($childCounter < count($childTimelineSegments)) {
                            // Move down
                            echo sprintf('<li>%s</li>',
                                $this->Form->postLink('', [
                                        'action' => 'moveDown',
                                        $childTimelineSegment->id,
                                    ], [
                                        'class' => [
                                            'action',
                                            'move-arrow',
                                            'arrow-down',
                                            'btn-info',
                                        ],
                            ]));
                            // Move to bottom
                            echo sprintf('<li>%s</li>',
                                $this->Form->postLink('', [
                                        'action' => 'moveDownBottom',
                                        $childTimelineSegment->id,
                                    ], [
                                        'class' => [
                                            'action',
                                            'move-arrow',
                                            'arrow-down',
                                            'bottom',
                                            'btn-info',
                                        ],
                            ]));
                    } ?>
                    <li><?= $this->Html->link('', [
                        'action' => 'edit',
                        $childTimelineSegment->id
                    ], [
                        'class'   => [
                            'action',
                            'button',
                            'edit-button',
                            'btn-primary',
                        ],
                    ]); ?></li>
                    <li><?= $this->Form->postLink('', [
                        'action' => 'delete',
                        $childTimelineSegment->id
                    ], [
                        'class'   => [
                            'action',
                            'button',
                            'delete-button',
                            'btn-danger',
                        ],
                        'confirm' => __('Are you sure you want to delete # {0}?', $childTimelineSegment->id),
                    ]); ?></li>
                </ul>
*/
?>