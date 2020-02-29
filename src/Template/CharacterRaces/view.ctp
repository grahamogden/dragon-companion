<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterRace $characterRace
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Character Race'), ['action' => 'edit', $characterRace->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Character Race'), ['action' => 'delete', $characterRace->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterRace->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Character Races'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character Race'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="characterRaces view large-9 medium-8 columns content">
    <h3><?= h($characterRace->name) ?></h3>
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
        <h4><?= __('Related Playable Characters') ?></h4>
        <?php if (!empty($characterRace->playable_characters)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('First Name') ?></th>
                <th scope="col"><?= __('Last Name') ?></th>
                <th scope="col"><?= __('Age') ?></th>
                <th scope="col"><?= __('Max Hp') ?></th>
                <th scope="col"><?= __('Current Hp') ?></th>
                <th scope="col"><?= __('Armour Class') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($characterRace->playable_characters as $playableCharacters): ?>
            <tr>
                <td><?= h($playableCharacters->id) ?></td>
                <td><?= h($playableCharacters->user_id) ?></td>
                <td><?= h($playableCharacters->first_name) ?></td>
                <td><?= h($playableCharacters->last_name) ?></td>
                <td><?= h($playableCharacters->age) ?></td>
                <td><?= h($playableCharacters->max_hp) ?></td>
                <td><?= h($playableCharacters->current_hp) ?></td>
                <td><?= h($playableCharacters->armour_class) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PlayableCharacters', 'action' => 'view', $playableCharacters->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PlayableCharacters', 'action' => 'edit', $playableCharacters->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PlayableCharacters', 'action' => 'delete', $playableCharacters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $playableCharacters->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
