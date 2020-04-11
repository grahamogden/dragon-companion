<?php
use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;
?>
<?php $childCounter = 0; ?>
<?php foreach ($childTimelineSegments as $childTimelineSegment) { ?>
    <?php $childCounter++; ?>
    <tr>
        <th class="align-items-center d-flex bg-light">
            <?= $this->Html->link(
                $childTimelineSegment->title,
                [
                    'action'     => 'view',
                    '_name'      => 'TimelineSegments',
                    'campaignId' => $childTimelineSegment->campaign_id,
                    'id'         => $childTimelineSegment->id,
                ]
            ) ?>
            <div class="dropdown d-inline-block ml-auto">
                <button class="btn btn-secondary dropdown-toggle shadow-none" type="button" id="timelineDropdownMenuButton<?=$childCounter?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                <div class="dropdown-menu dropdown-menu-right flex-column" aria-labelledby="timelineDropdownMenuButton<?=$childCounter?>">
                    <?php if ($childCounter > 1) { ?>
                        <?php // Move to top ?>
                        <?= $this->Form->postLink('Move to top', [
                            'action'     => 'moveUpTop',
                            '_name'      => 'TimelineSegments',
                            'campaignId' => $childTimelineSegment->campaign_id,
                            'id'         => $childTimelineSegment->id,
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
                            'action'     => 'moveUp',
                            '_name'      => 'TimelineSegments',
                            'campaignId' => $childTimelineSegment->campaign_id,
                            'id'         => $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-2'
                            ],
                            'role' => 'button',
                        ]); ?>
                    <?php } ?>

                    <?php if ($childCounter < count($childTimelineSegments)) { ?>
                        <?php // Move down ?>
                        <?= $this->Form->postLink('Move down', [
                            'action'     => 'moveDown',
                            '_name'      => 'TimelineSegments',
                            'campaignId' => $childTimelineSegment->campaign_id,
                            'id'         => $childTimelineSegment->id,
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
                            'action'     => 'moveDownBottom',
                            '_name'      => 'TimelineSegments',
                            'campaignId' => $childTimelineSegment->campaign_id,
                            'id'         => $childTimelineSegment->id,
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
                        'action'     => 'edit',
                        '_name'      => 'TimelineSegments',
                        'campaignId' => $childTimelineSegment->campaign_id,
                        'id'         => $childTimelineSegment->id,
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
                        '_name'  => 'TimelineSegmentsDelete',
                        'id'     => $childTimelineSegment->id,
                    ], [
                        'class'   => [
                            'btn',
                            'btn-danger',
                        ],
                        'role' => 'button',
                        'confirm' => __('Are you sure you want to delete {0}?', $childTimelineSegment->name),
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