<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<div class="participants form content">
    <h1>Edit Participant</h1>
    <?= $this->Form->create($participant) ?>
        <fieldset>
                <?= $this->Form->control('order') ?>
                <?= $this->Form->control('combat_encounter_id', ['options' => $combatEncounters]) ?>
                <?= $this->Form->control('conditions._ids', ['options' => $conditions]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
