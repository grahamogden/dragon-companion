<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CombatEncounter $combatEncounter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Combat Encounter'), ['action' => 'edit', $combatEncounter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Combat Encounter'), ['action' => 'delete', $combatEncounter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $combatEncounter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Combat Encounters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combat Encounter'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="combatEncounters view large-9 medium-8 columns content">
    <h3><?= h($combatEncounter->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($combatEncounter->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $combatEncounter->has('user') ? $this->Html->link($combatEncounter->user->id, ['controller' => 'Users', 'action' => 'view', $combatEncounter->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($combatEncounter->id) ?></td>
        </tr>
    </table>
</div>
