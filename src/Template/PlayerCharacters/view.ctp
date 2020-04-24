<?php

use App\Model\Entity\PlayerCharacter;
use App\View\AppView;

/**
 * @var AppView         $this
 * @var PlayerCharacter $playerCharacter
 */

?>
<div class="playerCharacters view large-9 medium-8 columns content">
    <h1><?= h($playerCharacter->first_name . ($playerCharacter->last_name ? ' ' . $playerCharacter->last_name : '')) ?></h1>
    <table class="table vertical-table">
        <tr>
            <th scope="row"><?= __('Age') ?></th>
            <td><?= $this->Number->format($playerCharacter->age) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Hit Points (max)') ?></th>
            <td><?= $this->Number->format($playerCharacter->max_hit_points) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Armour Class') ?></th>
            <td><?= $this->Number->format($playerCharacter->armour_class) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dexterity Modifier') ?></th>
            <td><?= $this->Number->format($playerCharacter->dexterity_modifier) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Campaign') ?></th>
            <td><?= h($playerCharacter->campaign->name) ?></td>
        </tr>
    </table>
    <div class="related">
        <h3><?= __('Character Classes') ?></h3>
        <?php if (!empty($playerCharacter->character_classes)): ?>
            <ul>
                <?php foreach ($playerCharacter->character_classes as $characterClasses): ?>
                    <li><?= h($characterClasses->name) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="related">
        <h3><?= __('Character Races') ?></h3>
        <?php if (!empty($playerCharacter->character_races)): ?>
            <ul>
                <?php foreach ($playerCharacter->character_races as $characterRaces): ?>
                    <li><?= h($characterRaces->name) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
