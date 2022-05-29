<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puzzle $puzzle
 */
echo $this->Html->script('puzzles.js');
?>
<div class="puzzles form add content">
    <h1>Add Puzzle</h1>
    <?= $this->Form->create($puzzle) ?>
        <fieldset>
            <?= $this->Form->control('title', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('description', ['class' => ['form-control']]) ?>
            <?= $this->Form->control(
                'map',
                [
                    'class' => 'form-control',
                    'value' => json_encode([
                        'rowCount' => 1,
                        'colCount' => 1,
                        'coordinateValues' => [[0]]
                    ]),
                    'readonly'
                ]) ?>
            <div id="puzzle-container" class="form-group">
                <div id="puzzle-controls" class="btn-toolbar form-group row" role="toolbar" aria-label="Puzzle toolbar with button groups">
                    <div class="btn-group col-md-6 mb-4 mb-md-0" role="group" aria-label="Puzzle toolbar group with buttons for adding columns and rows">
                        <button id="add-column" class="btn btn-primary text-nowrap" type="button" role="button">+ Column</button>
                        <button id="add-row" class="btn btn-primary text-nowrap" type="button" role="button">+ Row</button>
                    </div>
                    <div class="btn-group col-md-6" aria-label="Puzzle toolbar group with buttons for generating the puzzle or its data">
                        <!-- <button id="generate-code" type="button" class="btn btn-primary text-nowrap" role="button">Generate code</button> -->
                        <button id="generate-from" type="button" class="btn btn-primary text-nowrap" role="button">Generate from</button>
                    </div>
                </div>
                <div id="puzzle-container" class="form-group">
                    <table id="puzzle-table" class="mx-auto">
                    </table>
                </div>
            </div>
        </fieldset>
        <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
