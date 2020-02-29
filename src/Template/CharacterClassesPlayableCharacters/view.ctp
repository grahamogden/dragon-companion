<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterClassesPlayableCharacter $characterClassesPlayableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Character Classes Playable Character'), ['action' => 'edit', $characterClassesPlayableCharacter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Character Classes Playable Character'), ['action' => 'delete', $characterClassesPlayableCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterClassesPlayableCharacter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Character Classes Playable Characters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character Classes Playable Character'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Character Classes'), ['controller' => 'CharacterClasses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character Class'), ['controller' => 'CharacterClasses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="characterClassesPlayableCharacters view large-9 medium-8 columns content">
    <h3><?= h($characterClassesPlayableCharacter->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Character Class') ?></th>
            <td><?= $characterClassesPlayableCharacter->has('character_class') ? $this->Html->link($characterClassesPlayableCharacter->character_class->id, ['controller' => 'CharacterClasses', 'action' => 'view', $characterClassesPlayableCharacter->character_class->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Playable Character') ?></th>
            <td><?= $characterClassesPlayableCharacter->has('playable_character') ? $this->Html->link($characterClassesPlayableCharacter->playable_character->id, ['controller' => 'PlayableCharacters', 'action' => 'view', $characterClassesPlayableCharacter->playable_character->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($characterClassesPlayableCharacter->id) ?></td>
        </tr>
    </table>
</div>
