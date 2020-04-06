<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterRace $characterRace
 */
?>
<div class="characterRaces form content">
    <h1>Add Character Race</h1>
    <?= $this->Form->create($characterRace) ?>
        <fieldset>
                <?= $this->Form->control('name') ?>
                <?= $this->Form->control('player_characters._ids', ['options' => $playerCharacters]) ?>
            <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
