<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="tags view columns content">
    <h3><?= sprintf('%s (%s)',
        h($tag->title),
        $this->Html->link(__('edit'), ['action' => 'edit', $tag->id])
        ); ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($tag->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($tag->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tag->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($tag->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($tag->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($tag->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Timeline Segments') ?></h4>
        <?php if (!empty($tag->timeline_segments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Body') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Slug') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Lft') ?></th>
                <th scope="col"><?= __('Rght') ?></th>
                <th scope="col"><?= __('Level') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tag->timeline_segments as $timelineSegments): ?>
            <tr>
                <td><?= h($timelineSegments->id) ?></td>
                <td><?= h($timelineSegments->parent_id) ?></td>
                <td><?= h($timelineSegments->title) ?></td>
                <td><?= h($timelineSegments->body) ?></td>
                <td><?= h($timelineSegments->created) ?></td>
                <td><?= h($timelineSegments->modified) ?></td>
                <td><?= h($timelineSegments->slug) ?></td>
                <td><?= h($timelineSegments->user_id) ?></td>
                <td><?= h($timelineSegments->lft) ?></td>
                <td><?= h($timelineSegments->rght) ?></td>
                <td><?= h($timelineSegments->level) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'TimelineSegments', 'action' => 'view', $timelineSegments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'TimelineSegments', 'action' => 'edit', $timelineSegments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'TimelineSegments', 'action' => 'delete', $timelineSegments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $timelineSegments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
