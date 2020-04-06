<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlayerCharacter $playerCharacter
 */
?>
<div class="playerCharacters view content">
    <h1><?= sprintf('%s%s',
        h($playerCharacter->first_name),
        $playerCharacter->has('last_name') ? ' ' . $playerCharacter->last_name : ''
    ) ?></h1>
    <table class="table vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $playerCharacter->has('user') ? $this->Html->link($playerCharacter->user->username, ['controller' => 'Users', 'action' => 'view', $playerCharacter->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($playerCharacter->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($playerCharacter->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Age') ?></th>
            <td><?= $this->Number->format($playerCharacter->age) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Max HP') ?></th>
            <td><?= $this->Number->format($playerCharacter->max_hp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Current HP') ?></th>
            <td><?= $this->Number->format($playerCharacter->current_hp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Armour Class') ?></th>
            <td><?= $this->Number->format($playerCharacter->armour_class) ?></td>
        </tr>
    </table>
    <div class="related">
        <h3>Character Classes</h3>
        <?php if (!empty($playerCharacter->character_classes)): ?>
        <ul>
            <?php foreach ($playerCharacter->character_classes as $characterClasses): ?>
            <li>
                <?= $this->Html->link(
                    h($characterClasses->name),
                    [
                        'controller' => 'CharacterClasses',
                        'action' => 'view',
                        $characterClasses->id
                    ]
                ) ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    <div class="related">
        <h3>Character Races</h3>
        <?php if (!empty($playerCharacter->character_races)): ?>
        <ul>
            <?php foreach ($playerCharacter->character_races as $characterRaces): ?>
            <li>
                <?= $this->Html->link(
                    h($characterRaces->name),
                    [
                        'controller' => 'CharacterRaces',
                        'action' => 'view',
                        $characterRaces->id
                    ]
                ) ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
