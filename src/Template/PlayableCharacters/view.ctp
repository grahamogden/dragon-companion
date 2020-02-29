<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlayableCharacter $playableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Playable Character'), ['action' => 'edit', $playableCharacter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Playable Character'), ['action' => 'delete', $playableCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $playableCharacter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Playable Characters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Playable Character'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Character Classes'), ['controller' => 'CharacterClasses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character Class'), ['controller' => 'CharacterClasses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Character Races'), ['controller' => 'CharacterRaces', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character Race'), ['controller' => 'CharacterRaces', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="playableCharacters view large-9 medium-8 columns content">
    <h3><?= h($playableCharacter->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $playableCharacter->has('user') ? $this->Html->link($playableCharacter->user->id, ['controller' => 'Users', 'action' => 'view', $playableCharacter->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($playableCharacter->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($playableCharacter->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($playableCharacter->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Age') ?></th>
            <td><?= $this->Number->format($playableCharacter->age) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Max Hp') ?></th>
            <td><?= $this->Number->format($playableCharacter->max_hp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Current Hp') ?></th>
            <td><?= $this->Number->format($playableCharacter->current_hp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Armour Class') ?></th>
            <td><?= $this->Number->format($playableCharacter->armour_class) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Character Classes') ?></h4>
        <?php if (!empty($playableCharacter->character_classes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($playableCharacter->character_classes as $characterClasses): ?>
            <tr>
                <td><?= h($characterClasses->id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CharacterClasses', 'action' => 'view', $characterClasses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CharacterClasses', 'action' => 'edit', $characterClasses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CharacterClasses', 'action' => 'delete', $characterClasses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterClasses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Character Races') ?></h4>
        <?php if (!empty($playableCharacter->character_races)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($playableCharacter->character_races as $characterRaces): ?>
            <tr>
                <td><?= h($characterRaces->id) ?></td>
                <td><?= h($characterRaces->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CharacterRaces', 'action' => 'view', $characterRaces->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CharacterRaces', 'action' => 'edit', $characterRaces->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CharacterRaces', 'action' => 'delete', $characterRaces->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterRaces->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Participants') ?></h4>
        <?php if (!empty($playableCharacter->participants)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Playable Character Id') ?></th>
                <th scope="col"><?= __('Monster Instance Id') ?></th>
                <th scope="col"><?= __('Order') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($playableCharacter->participants as $participants): ?>
            <tr>
                <td><?= h($participants->id) ?></td>
                <td><?= h($participants->playable_character_id) ?></td>
                <td><?= h($participants->monster_instance_id) ?></td>
                <td><?= h($participants->order) ?></td>
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
