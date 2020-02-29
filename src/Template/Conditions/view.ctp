<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Condition $condition
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Condition'), ['action' => 'edit', $condition->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Condition'), ['action' => 'delete', $condition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $condition->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Conditions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Condition'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Combat Turns'), ['controller' => 'CombatTurns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Combat Turn'), ['controller' => 'CombatTurns', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="conditions view large-9 medium-8 columns content">
    <h3><?= h($condition->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($condition->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($condition->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($condition->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Combat Turns') ?></h4>
        <?php if (!empty($condition->combat_turns)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Combat Enounter Id') ?></th>
                <th scope="col"><?= __('Round Number') ?></th>
                <th scope="col"><?= __('Source Participant Id') ?></th>
                <th scope="col"><?= __('Target Participant Id') ?></th>
                <th scope="col"><?= __('Action Result') ?></th>
                <th scope="col"><?= __('Condition Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($condition->combat_turns as $combatTurns): ?>
            <tr>
                <td><?= h($combatTurns->id) ?></td>
                <td><?= h($combatTurns->combat_enounter_id) ?></td>
                <td><?= h($combatTurns->round_number) ?></td>
                <td><?= h($combatTurns->source_participant_id) ?></td>
                <td><?= h($combatTurns->target_participant_id) ?></td>
                <td><?= h($combatTurns->action_result) ?></td>
                <td><?= h($combatTurns->condition_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CombatTurns', 'action' => 'view', $combatTurns->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CombatTurns', 'action' => 'edit', $combatTurns->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CombatTurns', 'action' => 'delete', $combatTurns->id], ['confirm' => __('Are you sure you want to delete # {0}?', $combatTurns->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
