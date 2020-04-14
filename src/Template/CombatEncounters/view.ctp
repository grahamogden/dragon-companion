<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CombatEncounter $combatEncounter
 */
?>
<div class="combatEncounters view content">
    <h3><?= h($combatEncounter->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($combatEncounter->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $combatEncounter->user->username ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Campaign') ?></th>
            <td><?= $combatEncounter->has('campaign') ? $this->Html->link($combatEncounter->campaign->name, ['controller' => 'Campaigns', 'action' => 'view', $combatEncounter->campaign->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($combatEncounter->created) ?></td>
        </tr>
    </table>
    <div class="related">
        <h3><?= __('Related Participants') ?></h3>
        <?php if (!empty($combatEncounter->participants)): ?>
        <table class="table table-hover">
            <tr>
                <th scope="col"><?= __('Order') ?></th>
                <th scope="col"><?= __('Combat Encounter Id') ?></th>
                <th scope="col"><?= __('Starting Hit Points') ?></th>
                <th scope="col"><?= __('Current Hit Points') ?></th>
                <th scope="col"><?= __('Armour Class') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($combatEncounter->participants as $participants): ?>
            <tr>
                <td><?= h($participants->order) ?></td>
                <td><?= h($participants->combat_encounter_id) ?></td>
                <td><?= h($participants->starting_hit_points) ?></td>
                <td><?= h($participants->current_hit_points) ?></td>
                <td><?= h($participants->armour_class) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Participants', 'action' => 'view', $participants->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Participants', 'action' => 'edit', $participants->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Participants', 'action' => 'delete', $participants->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participants->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
