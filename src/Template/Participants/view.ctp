<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Participant'), ['action' => 'edit', $participant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Participant'), ['action' => 'delete', $participant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Monster Instances'), ['controller' => 'MonsterInstances', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monster Instance'), ['controller' => 'MonsterInstances', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="participants view large-9 medium-8 columns content">
    <h3><?= h($participant->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Playable Character') ?></th>
            <td><?= $participant->has('playable_character') ? $this->Html->link($participant->playable_character->id, ['controller' => 'PlayableCharacters', 'action' => 'view', $participant->playable_character->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Monster Instance') ?></th>
            <td><?= $participant->has('monster_instance') ? $this->Html->link($participant->monster_instance->name, ['controller' => 'MonsterInstances', 'action' => 'view', $participant->monster_instance->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($participant->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $this->Number->format($participant->order) ?></td>
        </tr>
    </table>
</div>
