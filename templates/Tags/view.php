<?php

use App\Model\Entity\Tag;
use App\View\AppView;

/**
 * @var AppView     $this
 * @var Tag $tag
 * @var array $timelineSegments
 */
?>
<div class="tags view columns content">
    <h1><?= sprintf('Tag - %s (%s)',
        h($tag->title),
        $this->Html->link(__('edit'), ['action' => 'edit', $tag->id])
        ) ?></h1>
    <div>
        <h3><?= __('Description') ?></h3>
        <div><?= $this->Text->autoParagraph($tag->description) ?></div>
    </div>
    <table class="table vertical-table">
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= $tag->created ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= $tag->modified ?></td>
        </tr>
    </table>
    <div>
        <h3><?= __('Related Timeline Segments') ?></h3>
        <?php if (empty($tag->timeline_segments)) { ?>
            <p>Tag not linked to any timeline segments.</p>
        <?php } else { ?>
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
