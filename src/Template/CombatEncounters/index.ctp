<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CombatEncounter[]|\Cake\Collection\CollectionInterface $combatEncounters
 */
?>
<div class="combatEncounters index content">
    <h1>Combat Tracker</h1>
    <div class="form-group">
        <?= $this->Html->link('New Combat Encounter', ['action' => 'add'], ['class' => ['btn','btn-outline-success']]); ?>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($combatEncounters as $combatEncounter): ?>
            <tr>
                <td><?= h($combatEncounter->name) ?></td>
                <td><?= $combatEncounter->has('user') ? $this->Html->link($combatEncounter->user->id, ['controller' => 'Users', 'action' => 'view', $combatEncounter->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $combatEncounter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $combatEncounter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $combatEncounter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $combatEncounter->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
