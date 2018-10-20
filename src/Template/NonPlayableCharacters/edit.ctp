<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonPlayableCharacter $nonPlayableCharacter
 */
?>
<h1>Edit Non Playable Character</h1>
<div class="nonPlayableCharacters form large-9 medium-8 columns content">
    <?= $this->Form->create($nonPlayableCharacter) ?>
    <fieldset>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('age');
            echo $this->Form->control('appearance');
            echo $this->Form->control('occupation');
            echo $this->Form->control('personality');
            echo $this->Form->control('history');
            echo $this->Form->control('alignment');
            echo $this->Form->control('notes');
        ?>
    </fieldset>
    <?= $this->Form->submit(__('Save')) ?>
    <?= $this->Form->end() ?>
</div>
