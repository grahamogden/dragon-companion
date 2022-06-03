<?php
use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;
use App\Model\Entity\TimelineSegment;
?>
<?php $childCounter = 0; ?>
<?php /** @var TimelineSegment[] $childTimelineSegments */ ?>
<?php foreach ($childTimelineSegments as $childTimelineSegment) { ?>
    <?php $childCounter++; ?>
    <tr>
        <th class="align-items-center d-flex background-colour-secondary">
            <?= $this->Html->link(
                $childTimelineSegment->title,
                [
                    'action'     => 'view',
                    'controller' => 'TimelineSegments',
                    'id'         => $childTimelineSegment->id,
                ]
            ) ?>
            <div class="dropdown d-inline-block ml-auto">
                <button class="btn btn-secondary dropdown-toggle shadow-none" type="button" id="timelineDropdownMenuButton<?=$childCounter?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                <div class="dropdown-menu dropdown-menu-right flex-column background-colour-secondary border-colour-primary" aria-labelledby="timelineDropdownMenuButton<?=$childCounter?>">
                    <?php if ($childCounter > 1) { ?>
                        <?php // Move to top ?>
                        <?= $this->Form->postLink('Move to top', [
                            'action'     => 'moveUpTop',
                            'controller' => 'TimelineSegments',
                            'id'         => $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-3',
                                'm-0',
                            ],
                            'role' => 'button',
                        ]); ?>

                        <?php // Move up ?>
                        <?= $this->Form->postLink('Move up', [
                            'action'     => 'moveUp',
                            'controller' => 'TimelineSegments',
                            'id'         => $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-3',
                                'm-0',
                            ],
                            'role' => 'button',
                        ]); ?>
                    <?php } ?>

                    <?php if ($childCounter < count($childTimelineSegments)) { ?>
                        <?php // Move down ?>
                        <?= $this->Form->postLink('Move down', [
                            'action'     => 'moveDown',
                            'controller' => 'TimelineSegments',
                            'id'         => $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-3',
                                'm-0',
                            ],
                            'role' => 'button',
                        ]); ?>

                        <?php // Move to bottom ?>
                        <?= $this->Form->postLink('Move to bottom', [
                            'action'     => 'moveDownBottom',
                            'controller' => 'TimelineSegments',
                            'id'         => $childTimelineSegment->id,
                        ], [
                            'class' => [
                                'btn',
                                'btn-info',
                                'mb-3',
                                'm-0',
                            ],
                            'role' => 'button',
                        ]); ?>
                    <?php } ?>

                    <?= $this->Html->link('Edit', [
                        'action'     => 'edit',
                        'controller' => 'TimelineSegments',
                        'id'         => $childTimelineSegment->id,
                    ], [
                        'class'   => [
                            'btn',
                            'btn-primary',
                            'mb-3',
                            'm-0',
                        ],
                        'role' => 'button',
                    ]); ?>

                    <?= $this->Form->postLink('Delete', [
                        'action'     => 'delete',
                        'controller' => 'TimelineSegments',
                        'id'         => $childTimelineSegment->id,
                    ], [
                        'class'   => [
                            'btn',
                            'btn-danger',
                            'm-0',
                        ],
                        'role' => 'button',
                        'confirm' => __('Are you sure you want to delete "{0}"?', $childTimelineSegment->title),
                    ]); ?>
                </div>
            </div>
        </th>
    </tr>
    <tr>
        <td class="show-more-container">
            <div class="show-more-content"><?= dbConverter::fromDatabase($childTimelineSegment->body); ?></div>
        </td>
    </tr>
<?php } // endforeach; ?>
