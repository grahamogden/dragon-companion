<?php
/**
 * @var \App\View\AppView                                            $this
 * @var \App\Model\Entity\Tag[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="tags index content">
    <h1>Tags</h1>
    <div class="form-group">
        <?= $this->Html->link(__('New Tag'), ['action' => 'add'], ['class' => ['btn', 'btn-outline-success']]); ?>
    </div>
    <table class="table table-hover">
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
                    <p><?=
                        $this->Html->link(
                            $tag->title,
                            [
                                'action' => 'edit',
                                $tag->id,
                            ]
                        ); ?></p>
                    <?= $tag->description ? sprintf('<p>%s</p>', h($tag->description)) : '' ?>
                </td>
                <td class="actions">
                    <?= $this->Form->postLink(
                        'Delete',
                        [
                            'action' => 'delete',
                            $tag->id,
                        ],
                        [
                            'class'   => [
                                'btn',
                                'btn-outline-danger',
                            ],
                            'confirm' => sprintf('Are you sure you want to delete #%d - %s?', $tag->id, $tag->title),
                        ]
                    ); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
</div>
