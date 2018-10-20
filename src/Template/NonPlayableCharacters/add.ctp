<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonPlayableCharacter $nonPlayableCharacter
 */
?>
<h1>Add Non Playable Character</h1>
<div class="nonPlayableCharacters form large-9 medium-8 columns content">
    <?= $this->Form->create($nonPlayableCharacter) ?>
    <fieldset>
        <?php
            echo $this->Form->control(
                'name', [
                    'spellcheck' => 'true']
            );
            echo $this->Form->control(
                'age', [
                    'spellcheck' => 'true']
            );
            echo $this->Form->control(
                'appearance', [
                    'spellcheck' => 'true']
            );
            echo $this->Form->control(
                'occupation', [
                    'spellcheck' => 'true']
            );
            echo $this->Form->control(
                'personality', [
                    'spellcheck' => 'true']
            );
            echo $this->Form->control(
                'history', [
                    'spellcheck' => 'true']
            );
            echo $this->Form->control(
                'alignment', [
                    'spellcheck' => 'true']
            );
            echo $this->Form->control(
                'notes', [
                    'spellcheck' => 'true']
            );
        ?>
    </fieldset>
    <?= $this->Form->submit(__('Save')) ?>
    <?= $this->Form->end() ?>
</div>
