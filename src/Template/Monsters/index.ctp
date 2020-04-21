<?php

use App\Model\Entity\Monster;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

/**
 * @var AppView                       $this
 * @var Monster[]|CollectionInterface $monsters
 * @var array                         $user
 */
?>
<div class="monsters index content">
    <h1><?= __('Monsters') ?></h1>
    <div class="form-group">
        <?= $this->Html->link(
            __('New Monster'),
            [
                'action' => 'add',
            ],
            [
                'class' => [
                    'btn',
                    'btn-outline-success',
                ],
            ]
        ) ?>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= __('Instance') ?></th>
            <th scope="col"><?= __('Visibility') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($monsters as $monster): ?>
            <tr>
                <td><?= $this->Html->link(h($monster->name), ['action' => 'view', $monster->id]) ?></td>
                <td><?= __($monster->monster_instance_type->name) ?></td>
                <td><?= ucfirst(strtolower(h($monster->visibility))) ?></td>
                <td class="actions">
                    <?= $monster->user_id === $user['id'] ? $this->Html->link(
                        __('Edit'),
                        ['action' => 'edit', $monster->id],
                        [
                            'class' => [
                                'btn',
                                'btn-outline-primary',
                            ],
                        ]
                    ) : '' ?>
                    <?= $monster->user_id === $user['id'] ? $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $monster->id],
                        [
                            'class'   => [
                                'btn',
                                'btn-outline-danger',
                            ],
                            'confirm' => __(
                                'Are you sure you want to delete # {0}?',
                                $monster->id
                            ),
                        ]
                    ) : '' ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
