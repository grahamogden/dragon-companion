<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="tags view columns content">
    <h3><?= sprintf('%s (%s)',
        $tag->title,
        $this->Html->link(__('edit'), ['action' => 'edit', $tag->id])
        ); ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= $tag->slug; ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= $tag->created; ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= $tag->modified; ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph($tag->description); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Timeline Segments') ?></h4>
        <?php if (!empty($tag->timeline_segments)) { ?>
        <table class="table table-hover">
            <tr>
                <th scope="col"><?= __('Tag'); ?></th>
                <th scope="col"><?= __('Level'); ?></th>
                <th scope="col" class="actions"><?= __('Actions'); ?></th>
            </tr>
            <?php foreach ($tag->timeline_segments as $timelineSegment) { ?>
            <tr>
                <td><p><?= $this->Html->link($timelineSegment->title, [
                        'controller' => 'TimelineSegments',
                        'action'     => 'view',
                        $timelineSegment->id
                    ]); ?></p>
                    <?= $this->Text->autoParagraph($timelineSegment->body); ?>
                </td>
                <td><?= $timelineSegment->level; ?></td>
                <td class="actions">
                    <?= $this->Html->link('', [
                        'controller' => 'TimelineSegments',
                        'action' => 'edit',
                        $timelineSegment->id,
                    ], [
                        'class'   => [
                            'action',
                            'button',
                            'edit-button',
                        ],
                    ]); ?>
                    <?= $this->Form->postLink('', [
                        'controller' => 'TimelineSegments',
                        'action' => 'delete',
                        $timelineSegment->id,
                    ], [
                        'confirm' => __('Are you sure you want to delete # {0}?', $timelineSegment->id),
                        'class'   => [
                            'action',
                            'button',
                            'delete-button'
                        ],
                    ]); ?>
                </td>
            </tr>
            <?php } // endforeach; ?>
        </table>
        <?php } // endif; ?>
    </div>
</div>
