<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterClass $characterClass
 */
?>
<div class="characterClasses form content">
    <h1>Add Character Class</h1>
    <?= $this->Form->create($characterClass) ?>
        <fieldset>
            <?= $this->Form->control('player_characters._ids', ['options' => $playerCharacters]) ?>
            <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
