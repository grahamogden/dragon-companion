<?php

use App\Model\Entity\PlayerCharacter;
use App\View\AppView;

/**
 * @var AppView         $this
 * @var PlayerCharacter $playerCharacter
 * @var array           $characterClasses
 * @var array           $characterRaces
 * @var array           $campaigns
 * @var array           $alignments
 */

?>
<div class="playerCharacters form content">
    <h1><?= __('Add Player Character') ?></h1>
    <?= $this->Form->create($playerCharacter) ?>
    <fieldset>
        <?= $this->Form->control('first_name', ['class' => ['form-control']]) ?>
        <?= $this->Form->control('last_name', ['class' => ['form-control']]) ?>
        <?= $this->Form->control('campaign_id', ['class' => ['form-control'], 'options' => $campaigns]) ?>
        <?= $this->Form->control('age', ['class' => ['form-control']]) ?>
        <?= $this->Form->control('max_hit_points', ['class' => ['form-control']]) ?>
        <?= $this->Form->control('armour_class', ['class' => ['form-control']]) ?>
        <?= $this->Form->control('dexterity_modifier', ['class' => ['form-control']]) ?>
        <?= $this->Form->control(
            'alignment_id',
            [
                'class'   => ['form-control'],
                'options' => $alignments,
            ]
        ) ?>
        <?= $this->Form->control(
            'character_classes._ids',
            [
                'options' => $characterClasses,
                'class'   => ['form-control'],
            ]
        ) ?>
        <?= $this->Form->control(
            'character_races._ids',
            [
                'options' => $characterRaces,
                'class'   => ['form-control'],
            ]
        ) ?>
        <?= $this->Form->submit('Save', ['class' => ['btn', 'btn-lg', 'btn-block', 'btn-success']]) ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>
