<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clan $clan
 */
?>
<div class="clans view content">
    <h1><?= h($clan->name) ?></h1>
    <div class="col-12">
        <h4>Admins:</h4>
        <ul>
            <?php foreach ($adminUsers as $adminUser): ?>
                <li><?= $adminUser->username ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="form-group">
        <h4>Description</h4>
        <?= $this->Text->autoParagraph(h($clan->description)); ?>
    </div>
    <div class="form-group">
        <h4>Related Users</h4>
        <?php if (!empty($clan->users)): ?>
        <table class="table table-hover">
            <tr>
                <th scope="col"><?= __('Username') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($memberUsers as $memberUser): ?>
                <tr>
                    <td><?= h($memberUser->username) ?></td>
                    <td><?= h($memberUser->email) ?: 'No email address set' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Unlink'), ['controller' => 'Users', 'action' => 'view', $memberUser->id]) ?>
                        <?php // echo $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
