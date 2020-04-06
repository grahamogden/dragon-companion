<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlayerCharacter[]|\Cake\Collection\CollectionInterface $playerCharacters
 */
?>
<div class="playerCharacters index content">
    <h1>Player Characters</h1>
    <div class="form-group">
        <?= $this->Html->link('New Player Character', ['action' => 'add'], ['class' => ['btn','btn-outline-success']]); ?>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                <th scope="col">Age</th>
                <th scope="col">Max HP</th>
                <th scope="col">Current HP</th>
                <th scope="col">Armour Class</th>
                <th scope="col" class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($playerCharacters as $playerCharacter): ?>
            <tr>
                <td><?= h($playerCharacter->first_name) ?></td>
                <td><?= h($playerCharacter->last_name) ?></td>
                <td><?= $this->Number->format($playerCharacter->age) ?></td>
                <td><?= $this->Number->format($playerCharacter->max_hp) ?></td>
                <td><?= $this->Number->format($playerCharacter->current_hp) ?></td>
                <td><?= $this->Number->format($playerCharacter->armour_class) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $playerCharacter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $playerCharacter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $playerCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $playerCharacter->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
