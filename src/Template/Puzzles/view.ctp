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
<div class="puzzles view large-9 medium-8 columns content">
    <h3>Puzzle <?php //h($puzzle->title) ?></h3>
    <div id="puzzle-container">
        <?php $this->Form->create($puzzle); ?>
        <?= $this->Form->control('map'); ?>
            <div id="puzzle-controls">
                <div id="generate-from" class="button">Generate from</div>
            </div>
        <table id="puzzle-table">
            <!-- <tr>
                <th scope="row"><?= __('User') ?></th>
                <td><?= $puzzle->has('user') ? $this->Html->link($puzzle->user->id, ['controller' => 'Users', 'action' => 'view', $puzzle->user->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Title') ?></th>
                <td><?= h($puzzle->title) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Slug') ?></th>
                <td><?= h($puzzle->slug) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($puzzle->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($puzzle->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($puzzle->modified) ?></td>
            </tr> -->
        </table>
        <div class="clear"></div>
    </div>
</div>
