<?php

use App\Model\Entity\NonPlayableCharacter;
use App\View\AppView;

/**
 * @var AppView              $this
 * @var NonPlayableCharacter $nonPlayableCharacter
 * @var array                $alignments
 */
?>
<h1>Add Non Playable Character</h1>
<div class="nonPlayableCharacters form content">
    <?= $this->Form->create($nonPlayableCharacter) ?>
    <fieldset>
        <?php
        echo $this->Form->control(
            'name',
            [
                'spellcheck' => 'true',
                'class'      => ['form-control'],
            ]
        );
        echo $this->Form->control(
            'age',
            [
                'spellcheck' => 'true',
                'class'      => ['form-control'],
            ]
        );
        echo $this->Form->control(
            'appearance',
            [
                'spellcheck' => 'true',
                'class'      => ['form-control'],
            ]
        );
        echo $this->Form->control(
            'occupation',
            [
                'spellcheck' => 'true',
                'class'      => ['form-control'],
            ]
        );
        echo $this->Form->control(
            'personality',
            [
                'spellcheck' => 'true',
                'class'      => ['form-control'],
            ]
        );
        echo $this->Form->control(
            'history',
            [
                'spellcheck' => 'true',
                'class'      => ['form-control'],
            ]
        );
        echo $this->Form->control(
            'alignment_id',
            [
                'class'      => ['form-control'],
                'options'    => $alignments,
            ]
        );
        echo $this->Form->control(
            'notes',
            [
                'spellcheck' => 'true',
                'class'      => ['form-control'],
            ]
        );
        ?>
    </fieldset>
    <?= $this->Form->submit('Save', ['class' => ['btn', 'btn-lg', 'btn-block', 'btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
