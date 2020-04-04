<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clan $clan
 */
?>
<div class="clans form content">
    <h1><?= $clan->name ?></h1>
    <?= $this->Form->create($clan) ?>
        <fieldset>
            <?= $this->Form->control('name', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('description', ['class' => ['form-control']]) ?>
            <?= $this->Form->label('Members') ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Username') ?></th>
                        <th scope="col"><?= __('Email') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clan->users as $user): ?>
                        <tr>
                            <td><?= h($user->username) ?></td>
                            <td><?= h($user->email) ?: 'No email address set' ?></td>
                            <td class="actions">
                                <?= $this->Form->postLink(
                                    __('Remove'),
                                    [
                                        'controller' => 'Clans',
                                        'action'     => 'deleteClanUser',
                                        // $clan->id,
                                        // $user->id
                                    ],
                                    [
                                        'class'   => [
                                            'btn',
                                            'btn-danger',
                                        ],
                                        'confirm' => __('Are you sure you want to remove {0}?',
                                        $user->username)
                                    ]
                                ) ?>
                                <?php // echo $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $this->Form->control('new_users', [
                'label'  => 'New Users',
                'type'   => 'autocomplete',
                'source' => [
                    'controller' => 'Clans',
                    'action'     => 'getUsers'
                ],
                'class' => ['form-control'],
                'data-excludes' => json_encode(['clanId' => $clan->id]),
            ]) ?>
        </fieldset>
        <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
