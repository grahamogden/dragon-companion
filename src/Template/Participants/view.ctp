<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<div class="participants view content">
    <h1><?= h($participant->id) ?></h1>
    <table class="vertical-table table">
        <tr>
            <th scope="row"><?= __('Player Character') ?></th>
            <td><?= $participant->has('player_character') ? $this->Html->link($participant->player_character->id, ['controller' => 'PlayerCharacters', 'action' => 'view', $participant->player_character->id]) : '' ?></td>
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
