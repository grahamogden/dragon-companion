<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimelineSegment $timelineSegment
 */
?>
<?= $this->element('breadcrumbs'); ?>
<h1><?= h($timelineSegment->title); ?> Timeline Segment</h1>
<?= $this->element('sidenav'); ?>
<div class="timelineSegments view columns content">
    <div class="segment-row">
        <h3><?= __('Title'); ?></h3>
        <p class="item"><?= h($timelineSegment->title); ?></p>
    </div>
    <!-- <div class="segment-row">
        <h3><?= __('Created'); ?></h3>
        <p class="item"><?= h($timelineSegment->created); ?></p>
    </div> -->
    <div class="segment-row">
        <h3><?= __('Body'); ?></h3>
        <p class="item"><?= $this->Text->autoParagraph(h($timelineSegment->body)); ?></p>
    </div>
    <?php if (!empty($timelineSegment->tags)) { ?>
        <div class="segment-row">
            <h3><?= __('Tags'); ?></h3>
            <?php foreach ($timelineSegment->tags as $tags) { ?>
                <div class="tag">
                    <p><?= h($tags->title); ?></p>
                </div>
            <?php } // endforeach; ?>
        </div>
    <?php } // endif; ?>
</div>
<div class="related">
    <h4><?= __('Child Timeline Segments'); ?></h4>
    <?php if (!empty($timelineSegment->child_timeline_segments)) { ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <!-- <th scope="col"><?= __('Id'); ?></th> -->
                <th scope="col" colspan="2"><?= __('Segments'); ?></th>
                <!-- <th scope="col" class="actions"><?= __('Actions'); ?></th> -->
            </tr>
            <?php
            $childCounter = 0;
            foreach ($timelineSegment->child_timeline_segments as $childTimelineSegments) {
                $childCounter++;
                ?>
                <tr>
                    <!-- <td><?= h($childTimelineSegments->getId()); ?></td> -->
                    <td>
                        <p>
                            <?= $this->Html->link(
                                $childTimelineSegments->title, [
                                    'action' => 'view',
                                    $childTimelineSegments->id,
                                ]
                            ); ?>
                        </p>
                        <p>
                            <?= __($childTimelineSegments->body); ?>
                        </p>
                    </td>
                    <td class="actions action-column">
                        <?= ($childCounter > 1
                            ?
                                $this->Form->postLink('', [
                                        'action'    => 'moveUp',
                                        $childTimelineSegments->getId(),
                                    ], [
                                        'class'   => [
                                            'action',
                                            'move-arrow',
                                            'arrow-up'
                                        ],
                                    ]
                                )
                            :
                                ''
                            ); ?>
                        <?= ($childCounter < count($timelineSegment->child_timeline_segments)
                            ?
                                $this->Form->postLink('', [
                                    'action'    => 'moveDown',
                                    $childTimelineSegments->getId(),
                                ], [
                                    'class'   => ['action', 'move-arrow', 'arrow-down'],
                                ])
                            :
                                ''
                            ); ?>
                        <?= $this->Form->postLink('', [
                            'controller' => 'TimelineSegments',
                            'action' => 'delete',
                            $childTimelineSegments->getId()
                        ], [
                            'class'   => ['action', 'button', 'delete-button'],
                            'confirm' => __('Are you sure you want to delete # {0}?', $childTimelineSegments->getId())
                        ]); ?>
                    </td>
                </tr>
            <?php } // endforeach; ?>
        </table>
    <?php } // endif; ?>
</div>
