<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puzzle $puzzle
 */
echo $this->Html->script('puzzles.js');
?>
<div class="puzzles form large-9 medium-8 columns content">
    <?= $this->Form->create($puzzle) ?>
    <fieldset>
        <legend><?= __('Add Puzzle') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('description');
            // echo $this->Form->control('parent_id', [
            //     'options' => $parentTimelineSegments,
            //     'empty'   => true,
            //     'value'   => $this->request->getQuery('parent') ?? null, // Automatically fill this value in for the user
            // ]);
            echo $this->Form->control('map', [
                'value' => '1|1|0',
            ]);
        ?>
        <div id="puzzle-container">
            <div id="puzzle-controls">
                <div id="add-column" class="button">
                    + Column
                </div>
                <div id="add-row" class="button">
                    + Row
                </div>
                <!-- <div id="generate-code" class="button">Generate code</div> -->
                <div id="generate-from" class="button">Generate from</div>
            </div>
            <table id="puzzle-table">
            </table>
            <div class="clear"></div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Save')) ?>
    <?= $this->Form->end() ?>
</div>
