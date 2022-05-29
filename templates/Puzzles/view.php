<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puzzle $puzzle
 */
echo $this->Html->script('puzzles.js');
?>
<!-- <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Puzzle'), ['action' => 'edit', $puzzle->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Puzzle'), ['action' => 'delete', $puzzle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $puzzle->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Puzzles'), ['action' => 'index']) ?> </li>
    </ul>
</nav> -->
<div class="puzzles view content">
    <h1>Puzzle <?php //echo h($puzzle->title) ?></h1>
    <div id="puzzle-container">
        <?php $this->Form->create($puzzle); ?>
        <?= $this->Form->control('map'); ?>
        <div id="puzzle-container" class="form-group">
            <table id="puzzle-table" class="mx-auto">
            </table>
        </div>
        <?php $this->Form->end(); ?>
    </div>
</div>
