<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monster $monster
 */
?>
<div class="monsters form content">
    <h1>Add Monster</h1>
    <?= $this->Form->create($monster) ?>
        <fieldset>
            <?= $this->Form->control('name', ['class' => 'form-control',]) ?>
            <?= $this->Form->control('max_hit_points', ['class' => 'form-control',]) ?>
            <?= $this->Form->control('armour_class', ['class' => 'form-control',]) ?>
            <?= $this->Form->control('data_source_id', ['class' => 'form-control', 'options' => $dataSources,]) ?>
            <?= $this->Form->control('source_location', ['class' => 'form-control',]) ?>
            <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
