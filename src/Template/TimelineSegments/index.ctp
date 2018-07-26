<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment[]|\Cake\Collection\CollectionInterface $timelineSegments
 */
?>
<h1><?= __('Timeline Segments') ?></h1>
<?= $this->element('sidenav'); ?>
<div class="timelineSegments index large-9 medium-8 columns content">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" colspan="2"><?= __('Child Timeline Segments') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 0;
            foreach ($timelineSegments as $timelineSegment) {
                $counter++;
                ?>
            <tr>
                <td>
                    <p>
                        <?php
                            echo $this->Html->link(
                                $timelineSegment->title, [
                                    'action' => 'view',
                                    $timelineSegment->id,
                                ]
                            );
                        ?>
                    </p>
                    <p>
                        <?= __($timelineSegment->body) ?>
                    </p>
                </td>
                <td class="actions action-column">
                    <?= ($counter > 1
                        ?
                            $this->Form->postLink('', [
                                    'action' => 'moveUp',
                                    $timelineSegment->getId()
                                ], [
                                    'confirm' => __('Are you sure you want to move up # {0}?', $timelineSegment->getId()),
                                    'class'   => [
                                        'action',
                                        'move-arrow',
                                        'arrow-up'
                                    ],
                                ])
                        :
                            ''
                    ) ?>
                    <?= ($counter < count($timelineSegments)
                        ?
                            $this->Form->postLink('', [
                                    'action' => 'moveDown',
                                    $timelineSegment->getId()
                                ], [
                                    'confirm' => __('Are you sure you want to move down # {0}?', $timelineSegment->getId()),
                                    'class'   => [
                                        'action',
                                        'move-arrow',
                                        'arrow-down'
                                    ],
                                ])
                        :
                            ''
                    ) ?>
                    <?= $this->Form->postLink('', [
                        'action' => 'delete',
                        $timelineSegment->id
                    ], [
                        'confirm' => __('Are you sure you want to delete # {0}?', $timelineSegment->id),
                        'class'   => [
                            'action',
                            'button',
                            'delete-button'
                        ],
                    ]) ?>
                </td>
            </tr>
            <?php } // endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
</div>
