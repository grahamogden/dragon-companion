<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clan[]|\Cake\Collection\CollectionInterface $clans
 */
?>
<div class="clans index content">
    <h1>Clans</h1>
    <div class="form-group">
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-outline-success"><i class="fa fa-plus"></i><?= __('New Clan') ?></a>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clans as $clan): ?>
                <?php foreach ($clan->_matchingData as $clanUser): ?>
                    <?php $userIsAdmin = false; ?>
                    <?php if ($clanUser->account_level): ?>
                        <?php $userIsAdmin = true; ?>
                        <?php break; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr>
                    <td>
                    <?= $this->Html->link(
                        h($clan->name),
                        [
                            'action' => $userIsAdmin ? 'edit' : 'view',
                            $clan->id
                        ]
                    ) ?></td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clan->id], [
                            'class'   => [
                                'btn',
                                'btn-outline-danger'
                            ],
                            'confirm' => __('Are you sure you want to delete # {0}?', $clan->id)
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
</div>
