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
            <?= $this->Form->control('player_character_id', ['options' => $playerCharacters, 'empty' => true]) ?>
            <?= $this->Form->control('monster_instance_id', ['options' => $monsterInstances, 'empty' => true]) ?>
            <?= $this->Form->control('order') ?>
            <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
