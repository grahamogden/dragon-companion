<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puzzle $puzzle
 */
?>
<div class="puzzles form large-9 medium-8 columns content">
    <?= $this->Form->create($puzzle) ?>
    <fieldset>
        <legend><?= __('Add Puzzle') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save')) ?>
    <?= $this->Form->end() ?>
</div>
