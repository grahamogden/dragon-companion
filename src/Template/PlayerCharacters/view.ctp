<?php

use App\Model\Entity\PlayerCharacter;
use App\View\AppView;

/**
 * @var AppView         $this
 * @var PlayerCharacter $playerCharacter
 */

?>
<div class="playerCharacters view large-9 medium-8 columns content">
    <h1><?= h(
            $playerCharacter->first_name . ($playerCharacter->last_name ? ' ' . $playerCharacter->last_name : '')
        ) ?></h1>
    <table class="table vertical-table">
        <tr>
            <th><?= __('Age') ?></th>
            <td><?= $this->Number->format($playerCharacter->age) ?></td>
        </tr>
        <tr>
            <th><?= __('Hit Points (max)') ?></th>
            <td><?= $this->Number->format($playerCharacter->max_hit_points) ?></td>
        </tr>
        <tr>
            <th><?= __('Armour Class') ?></th>
            <td><?= $this->Number->format($playerCharacter->armour_class) ?></td>
        </tr>
        <tr>
            <th><?= __('Dexterity Modifier') ?></th>
            <td><?= $this->Number->format($playerCharacter->dexterity_modifier) ?></td>
        </tr>
        <tr>
            <th><?= __('Alignment') ?></th>
            <td><?= __($playerCharacter->alignment->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Campaign') ?></th>
            <td><?= h($playerCharacter->campaign->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Character Classes') ?></th>
            <td>
                <ul>
                    <?php if (empty($playerCharacter->character_classes)) { ?>
                        <li>No race selected</li>
                    <?php } else { ?>
                        <?php foreach ($playerCharacter->character_classes as $characterClasses) { ?>
                            <li><?= h($characterClasses->name) ?></li>
                        <?php } // endforeach; ?>
                    <?php } // endif; ?>
                </ul>
            </td>
        </tr>
        <tr>
            <th><?= __('Character Races') ?></th>
            <td>
                <ul>
                    <?php if (empty($playerCharacter->character_races)) { ?>
                        <li>No race selected</li>
                    <?php } else { ?>
                        <?php foreach ($playerCharacter->character_races as $characterRaces) { ?>
                            <li><?= h($characterRaces->name) ?></li>
                        <?php } // endforeach; ?>
                    <?php } // endif; ?>
                </ul>

            </td>
        </tr>
    </table>
</div>
