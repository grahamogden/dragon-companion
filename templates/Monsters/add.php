<?php

use App\Model\Entity\Monster;
use App\View\AppView;

/**
 * @var AppView $this
 * @var Monster $monster
 * @var array   $monsterInstanceTypes
 * @var array   $dataSources
 * @var array   $alignments
 */
?>
<div class="monsters form content">
    <h1>Add Monster</h1>
    <?= $this->Form->create($monster) ?>
    <fieldset>
        <?= $this->Form->control('name', ['class' => 'form-control',]) ?>
        <?= $this->Form->control(
            'visibility',
            [
                'class'   => 'form-control',
                'options' => Monster::VISIBILITY_OPTIONS,
            ]
        ) ?>
        <?= $this->Form->control('max_hit_points', ['class' => 'form-control',]) ?>
        <?= $this->Form->control('armour_class', ['class' => 'form-control',]) ?>
        <?= $this->Form->control('dexterity_modifier', ['class' => 'form-control',]) ?>
        <?= $this->Form->control(
            'alignment_id',
            [
                'class'   => ['form-control'],
                'options' => $alignments,
            ]
        ) ?>
        <?= $this->Form->control(
            'monster_instance_type_id',
            [
                'class'   => 'form-control',
                'options' => $monsterInstanceTypes,
                'value',
            ]
        ) ?>
        <?= $this->Form->control('data_source_id', ['class' => 'form-control', 'options' => $dataSources,]) ?>
        <?= $this->Form->control('source_location', ['class' => 'form-control',]) ?>
        <?= $this->Form->submit('Save', ['class' => ['btn', 'btn-lg', 'btn-block', 'btn-success']]) ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>
