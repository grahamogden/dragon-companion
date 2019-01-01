<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Puzzle $puzzle
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Puzzle'), ['action' => 'edit', $puzzle->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Puzzle'), ['action' => 'delete', $puzzle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $puzzle->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Puzzles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Puzzle'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="puzzles view large-9 medium-8 columns content">
    <h3><?= h($puzzle->title) ?></h3>
    <table class="vertical-table">
        <tr>
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
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($puzzle->description)); ?>
    </div>
</div>
