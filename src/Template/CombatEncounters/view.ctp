<?php
/**
 * @var \App\View\AppView                 $this
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
            <th scope="row"><?= __('Campaign') ?></th>
            <td><?= $combatEncounter->has('campaign') ? $this->Html->link(
                    $combatEncounter->campaign->name,
                    [
                        'controller' => 'Campaigns',
                        'action'     => 'view',
                        $combatEncounter->campaign->id,
                    ]
                ) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($combatEncounter->created) ?></td>
        </tr>
    </table>
    <div class="related">
        <h3><?= __('Participants') ?></h3>
        <?php if (!empty($combatEncounter->participants)): ?>
            <table class="table table-hover">
                <tr>
                    <th scope="col"><?= __('Initiative') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Starting Hit Points') ?></th>
                    <th scope="col"><?= __('Current Hit Points') ?></th>
                    <th scope="col"><?= __('Armour Class') ?></th>
                </tr>
                <?php foreach ($combatEncounter->participants as $participant): ?>
                    <tr>
                        <td><?= h($participant->initiative) ?></td>
                        <td><?= $participant->has('monster')
                                ? h($participant->monster->name)
                                : h(
                                    sprintf(
                                        '%s%s',
                                        $participant->player_character->first_name,
                                        ' ' . $participant->player_character->last_name
                                    )
                                )
                            ?></td>
                        <td><?= h($participant->starting_hit_points) ?></td>
                        <td><?= h($participant->current_hit_points) ?></td>
                        <td><?= h($participant->armour_class) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h3><?= __('Turns') ?></h3>
        <?php if (!empty($combatEncounter->combat_turns)): ?>
            <table class="table table-hover">
                <tr>
                    <th scope="col"><?= __('Round Number') ?></th>
                    <th scope="col"><?= __('Source') ?></th>
                    <th scope="col"><?= __('Action') ?></th>
                    <th scope="col"><?= __('Target') ?></th>
                    <th scope="col"><?= __('Total') ?></th>
                    <th scope="col"><?= __('Movement') ?></th>
                </tr>
                <?php foreach ($combatEncounter->combat_turns as $combatTurn): ?>
                    <tr>
                        <td><?= h($combatTurn->round_number) ?></td>
                        <td><?php if ($combatTurn->has('source_participant')) { ?>
                            <?= $combatTurn->source_participant->has('monster')
                                    ? h($combatTurn->source_participant->monster->name)
                                    : h(
                                    sprintf(
                                        '%s%s',
                                        $combatTurn->source_participant->player_character->first_name,
                                        ' ' . $combatTurn->source_participant->player_character->last_name
                                    )
                                )
                            ?><?php } ?></td>
                        <td><?= h($combatTurn->combat_action->name) ?></td>
                        <td><?php if ($combatTurn->has('target_participant')) { ?>
                            <?= $combatTurn->target_participant->has('monster')
                                ? h($combatTurn->target_participant->monster->name)
                                : h(
                                    sprintf(
                                        '%s%s',
                                        $combatTurn->target_participant->player_character->first_name,
                                        ' ' . $combatTurn->target_participant->player_character->last_name
                                    )
                                )
                            ?><?php } ?></td>
                        <td><?= h($combatTurn->net_action_total) ?></td>
                        <td><?= h($combatTurn->movement) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
