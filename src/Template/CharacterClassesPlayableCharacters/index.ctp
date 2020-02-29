<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterClassesPlayableCharacter[]|\Cake\Collection\CollectionInterface $characterClassesPlayableCharacters
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Character Classes Playable Character'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Character Classes'), ['controller' => 'CharacterClasses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character Class'), ['controller' => 'CharacterClasses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="characterClassesPlayableCharacters index large-9 medium-8 columns content">
    <h3><?= __('Character Classes Playable Characters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('character_class_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('player_character_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($characterClassesPlayableCharacters as $characterClassesPlayableCharacter): ?>
            <tr>
                <td><?= $this->Number->format($characterClassesPlayableCharacter->id) ?></td>
                <td><?= $characterClassesPlayableCharacter->has('character_class') ? $this->Html->link($characterClassesPlayableCharacter->character_class->id, ['controller' => 'CharacterClasses', 'action' => 'view', $characterClassesPlayableCharacter->character_class->id]) : '' ?></td>
                <td><?= $characterClassesPlayableCharacter->has('playable_character') ? $this->Html->link($characterClassesPlayableCharacter->playable_character->id, ['controller' => 'PlayableCharacters', 'action' => 'view', $characterClassesPlayableCharacter->playable_character->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $characterClassesPlayableCharacter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $characterClassesPlayableCharacter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $characterClassesPlayableCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterClassesPlayableCharacter->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
