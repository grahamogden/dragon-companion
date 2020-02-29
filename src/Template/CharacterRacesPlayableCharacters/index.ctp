<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterRacesPlayableCharacter[]|\Cake\Collection\CollectionInterface $characterRacesPlayableCharacters
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Character Races Playable Character'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Character Races'), ['controller' => 'CharacterRaces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character Race'), ['controller' => 'CharacterRaces', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="characterRacesPlayableCharacters index large-9 medium-8 columns content">
    <h3><?= __('Character Races Playable Characters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('character_race_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('playable_character_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($characterRacesPlayableCharacters as $characterRacesPlayableCharacter): ?>
            <tr>
                <td><?= $this->Number->format($characterRacesPlayableCharacter->id) ?></td>
                <td><?= $characterRacesPlayableCharacter->has('character_race') ? $this->Html->link($characterRacesPlayableCharacter->character_race->name, ['controller' => 'CharacterRaces', 'action' => 'view', $characterRacesPlayableCharacter->character_race->id]) : '' ?></td>
                <td><?= $characterRacesPlayableCharacter->has('playable_character') ? $this->Html->link($characterRacesPlayableCharacter->playable_character->id, ['controller' => 'PlayableCharacters', 'action' => 'view', $characterRacesPlayableCharacter->playable_character->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $characterRacesPlayableCharacter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $characterRacesPlayableCharacter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $characterRacesPlayableCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterRacesPlayableCharacter->id)]) ?>
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
