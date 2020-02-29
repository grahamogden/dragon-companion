<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterClass $characterClass
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Character Class'), ['action' => 'edit', $characterClass->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Character Class'), ['action' => 'delete', $characterClass->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterClass->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Character Classes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character Class'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['controller' => 'PlayableCharacters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Playable Character'), ['controller' => 'PlayableCharacters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="characterClasses view large-9 medium-8 columns content">
    <h3><?= h($characterClass->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($characterClass->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Playable Characters') ?></h4>
        <?php if (!empty($characterClass->playable_characters)): ?>
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
            <?php foreach ($characterClass->playable_characters as $playableCharacters): ?>
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
