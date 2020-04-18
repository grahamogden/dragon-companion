<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterRace[]|\Cake\Collection\CollectionInterface $characterRaces
 */
?>
<div class="characterRaces index content">
    <h1>Character Races</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($characterRaces as $characterRace): ?>
            <tr>
                <td><?= $this->Number->format($characterRace->id) ?></td>
                <td><?= h($characterRace->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $characterRace->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $characterRace->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $characterRace->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterRace->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
