<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="tags index large-9 medium-8 columns content">
    <h3>Tags</h3>
    <?= $this->Html->link(__('New Tag'), ['action' => 'add']); ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('title'); ?></th>
                <th scope="col" class="action-column">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $tag): ?>
            <tr>
                <td>
                    <p><?= sprintf('%s - %s',
                        $this->Html->link($tag->title, [
                            'action' => 'view',
                            $tag->id,
                        ]),
                        h($tag->slug)); ?></p>
                    <p><?= h($tag->description) ?></p>
                </td>
                <td class="action-column">
                    <div class="horizontal">
                        <ul>
                            <li>
                                <?= $this->Html->link('', [
                                    'action' => 'edit',
                                    $tag->id
                                ], [
                                    'class'   => [
                                        'action',
                                        'button',
                                        'edit-button'
                                    ],
                                ]); ?>
                            </li>
                            <li>
                                <?= $this->Form->postLink('', [
                                    'action' => 'delete',
                                    $tag->id
                                ], [
                                    'class'   => [
                                        'action',
                                        'button',
                                        'delete-button'
                                    ],
                                    'confirm' => __('Are you sure you want to delete # {0}?', $tag->id),
                                ]); ?>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
</div>
