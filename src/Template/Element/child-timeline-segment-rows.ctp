<?php
use App\Model\Behavior\DatabaseStringConverterBehavior as dbConverter;

$childCounter = 0;
foreach ($childTimelineSegments as $childTimelineSegment) {
    $childCounter++;
    ?>
    <tr>
        <td>
            <p><?= $this->Html->link($childTimelineSegment->title, [
                    'action' => 'view',
                    $childTimelineSegment->id,
                ]); ?></p>
            <?= dbConverter::fromDatabase($this->Text->autoParagraph($childTimelineSegment->body)); ?>
        </td>
        <td class="actions action-column">
            <div>
                <a class="menu-button action">. . .</a>
                <ul class="menu">
                    <?= ($childCounter > 1
                        ?
                            sprintf('<li>%s</li>',
                                $this->Form->postLink('', [
                                        'action' => 'moveUp',
                                        $childTimelineSegment->id
                                    ], [
                                        'class' => [
                                            'action',
                                            'move-arrow',
                                            'arrow-up'
                                        ],
                            ]))
                        :
                            ''
                    ); ?>
                    <?= ($childCounter < count($childTimelineSegments)
                        ?
                            sprintf('<li>%s</li>',
                                $this->Form->postLink('', [
                                        'action' => 'moveDown',
                                        $childTimelineSegment->id
                                    ], [
                                        'class' => [
                                            'action',
                                            'move-arrow',
                                            'arrow-down'
                                        ],
                            ]))
                        :
                            ''
                    ); ?>
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
        </td>
    </tr>
<?php } // endforeach; ?>