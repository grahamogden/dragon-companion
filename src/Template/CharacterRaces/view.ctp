<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterRace $characterRace
 */
?>
<div class="characterRaces view content">
    <h1><?= h($characterRace->name) ?></h1>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($characterRace->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($characterRace->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Player Characters') ?></h4>
        <?php if (!empty($characterRace->player_characters)): ?>
        <table class="table table-hover">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('First Name') ?></th>
                <th scope="col"><?= __('Last Name') ?></th>
                <th scope="col"><?= __('Age') ?></th>
                <th scope="col"><?= __('Max Hp') ?></th>
                <th scope="col"><?= __('Current Hp') ?></th>
                <th scope="col"><?= __('Armour Class') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($characterRace->player_characters as $playerCharacters): ?>
            <tr>
                <td><?= h($playerCharacters->user_id) ?></td>
                <td><?= h($playerCharacters->first_name) ?></td>
                <td><?= h($playerCharacters->last_name) ?></td>
                <td><?= h($playerCharacters->age) ?></td>
                <td><?= h($playerCharacters->max_hp) ?></td>
                <td><?= h($playerCharacters->current_hp) ?></td>
                <td><?= h($playerCharacters->armour_class) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PlayerCharacters', 'action' => 'view', $playerCharacters->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PlayerCharacters', 'action' => 'edit', $playerCharacters->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PlayerCharacters', 'action' => 'delete', $playerCharacters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $playerCharacters->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
