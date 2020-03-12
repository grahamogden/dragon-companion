<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CombatEncounter $combatEncounter
 */
?>
<div class="combatEncounters form content">
    <h1>Edit Combat Encounter</h1>
    <?= $this->Form->create($combatEncounter) ?>
        <fieldset>
            <?= $this->Form->control('name') ?>
            <?= $this->Form->textarea('json', ['class' => ['form-control'], 'readonly']) ?>
        </fieldset>
        <?= $this->Form->submit('Save Encounter', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
