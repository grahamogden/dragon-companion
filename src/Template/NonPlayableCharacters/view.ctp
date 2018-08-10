<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonPlayableCharacter $nonPlayableCharacter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Non Playable Character'), ['action' => 'edit', $nonPlayableCharacter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Non Playable Character'), ['action' => 'delete', $nonPlayableCharacter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nonPlayableCharacter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Non Playable Characters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Non Playable Character'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="nonPlayableCharacters view large-9 medium-8 columns content">
    <h3><?= h($nonPlayableCharacter->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($nonPlayableCharacter->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Occupation') ?></th>
            <td><?= h($nonPlayableCharacter->occupation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tag') ?></th>
            <td><?= $nonPlayableCharacter->has('tag') ? $this->Html->link($nonPlayableCharacter->tag->title, ['controller' => 'Tags', 'action' => 'view', $nonPlayableCharacter->tag->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($nonPlayableCharacter->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Age') ?></th>
            <td><?= $this->Number->format($nonPlayableCharacter->age) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alignment') ?></th>
            <td><?= $this->Number->format($nonPlayableCharacter->alignment) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Appearance') ?></h4>
        <?= $this->Text->autoParagraph(h($nonPlayableCharacter->appearance)); ?>
    </div>
    <div class="row">
        <h4><?= __('Personality') ?></h4>
        <?= $this->Text->autoParagraph(h($nonPlayableCharacter->personality)); ?>
    </div>
    <div class="row">
        <h4><?= __('History') ?></h4>
        <?= $this->Text->autoParagraph(h($nonPlayableCharacter->history)); ?>
    </div>
    <div class="row">
        <h4><?= __('Notes') ?></h4>
        <?= $this->Text->autoParagraph(h($nonPlayableCharacter->notes)); ?>
    </div>
</div>
