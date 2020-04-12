<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlayerCharacter $playerCharacter
 */
?>
<div class="playerCharacters form content">
    <h1><?= __('Add Player Character') ?></h1>
    <?= $this->Form->create($playerCharacter) ?>
        <fieldset>
            <?= $this->Form->control('first_name', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('last_name', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('age', ['class' => ['form-control']]) ?>
            <?= $this->Form->control(
                'character_classes._ids',
                [
                    'options' => $characterClasses,
                    'class' => ['form-control']
                ]
            ) ?>
            <?= $this->Form->control(
                'character_races._ids',
                [
                    'options' => $characterRaces,
                    'class' => ['form-control']
                ]
            ) ?>
            <?= $this->Form->control('max_hp', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('armour_class', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('campaign_id', ['options' => $campaigns]) ?>
        <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
