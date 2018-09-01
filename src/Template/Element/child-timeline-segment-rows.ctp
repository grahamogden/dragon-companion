<?php
use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;

$childCounter = 0;
foreach ($childTimelineSegments as $childTimelineSegment) {
    $childCounter++;
    ?>
    <tr>
        <th>
            <?= $this->Html->link($childTimelineSegment->title, [
                'action' => 'view',
                $childTimelineSegment->id,
            ]); ?>
            <div class="actions actions-fixed">
                <a class="menu-button action">. . .</a>
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
                            'edit-button'
                        ],
                    ]); ?></li>
                    <li><?= $this->Form->postLink('', [
                        'action' => 'delete',
                        $childTimelineSegment->id
                    ], [
                        'class'   => [
                            'action',
                            'button',
                            'delete-button'
                        ],
                        'confirm' => __('Are you sure you want to delete # {0}?', $childTimelineSegment->id),
                    ]); ?></li>
                </ul>
            </div>
        </th>
    </tr>
    <tr>
        <td class="show-more-container">
            <div class="show-more-content"><?= dbConverter::fromDatabase($this->Text->autoParagraph($childTimelineSegment->body)); ?></div>
        </td>
    </tr>
<?php } // endforeach; ?>