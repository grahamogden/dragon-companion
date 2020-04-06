<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant[]|\Cake\Collection\CollectionInterface $participants
 */
?>
<div class="participants index content">
    <h1>Participants</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('player_character_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('monster_instance_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $participant): ?>
            <tr>
                <td><?= $participant->has('player_character') ? $this->Html->link($participant->player_character->id, ['controller' => 'PlayerCharacters', 'action' => 'view', $participant->player_character->id]) : '' ?></td>
                <td><?= $participant->has('monster_instance') ? $this->Html->link($participant->monster_instance->name, ['controller' => 'MonsterInstances', 'action' => 'view', $participant->monster_instance->id]) : '' ?></td>
                <td><?= $this->Number->format($participant->order) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $participant->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $participant->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $participant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
