<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonPlayableCharacter $nonPlayableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Non Playable Characters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Timeline Segments'), ['controller' => 'TimelineSegments', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="nonPlayableCharacters form large-9 medium-8 columns content">
    <?= $this->Form->create($nonPlayableCharacter) ?>
    <fieldset>
        <legend><?= __('Add Non Playable Character') ?></legend>
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
