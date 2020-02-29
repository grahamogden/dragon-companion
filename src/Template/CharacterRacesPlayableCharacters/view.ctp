<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterRacesPlayableCharacter $characterRacesPlayableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Character Races Playable Character'), ['action' => 'edit', $characterRacesPlayableCharacter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Character Races Playable Character'), ['action' => 'delete', $characterRacesPlayableCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterRacesPlayableCharacter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Character Races Playable Characters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character Races Playable Character'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Character Races'), ['controller' => 'CharacterRaces', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character Race'), ['controller' => 'CharacterRaces', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="characterRacesPlayableCharacters view large-9 medium-8 columns content">
    <h3><?= h($characterRacesPlayableCharacter->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Character Race') ?></th>
            <td><?= $characterRacesPlayableCharacter->has('character_race') ? $this->Html->link($characterRacesPlayableCharacter->character_race->name, ['controller' => 'CharacterRaces', 'action' => 'view', $characterRacesPlayableCharacter->character_race->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Playable Character') ?></th>
            <td><?= $characterRacesPlayableCharacter->has('playable_character') ? $this->Html->link($characterRacesPlayableCharacter->playable_character->id, ['controller' => 'PlayableCharacters', 'action' => 'view', $characterRacesPlayableCharacter->playable_character->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($characterRacesPlayableCharacter->id) ?></td>
        </tr>
    </table>
</div>
