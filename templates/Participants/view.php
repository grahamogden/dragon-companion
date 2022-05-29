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
        <li><?= $this->Html->link(__('List Combat Encounters'), ['controller' => 'CombatEncounters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combat Encounter'), ['controller' => 'CombatEncounters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Conditions'), ['controller' => 'Conditions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Condition'), ['controller' => 'Conditions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="participants view large-9 medium-8 columns content">
    <h3><?= h($participant->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Combat Encounter') ?></th>
            <td><?= $participant->has('combat_encounter') ? $this->Html->link($participant->combat_encounter->name, ['controller' => 'CombatEncounters', 'action' => 'view', $participant->combat_encounter->id]) : '' ?></td>
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
    <div class="related">
        <h4><?= __('Related Conditions') ?></h4>
        <?php if (!empty($participant->conditions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($participant->conditions as $conditions): ?>
            <tr>
                <td><?= h($conditions->id) ?></td>
                <td><?= h($conditions->name) ?></td>
                <td><?= h($conditions->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Conditions', 'action' => 'view', $conditions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Conditions', 'action' => 'edit', $conditions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Conditions', 'action' => 'delete', $conditions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $conditions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
