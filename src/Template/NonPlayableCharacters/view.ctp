<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonPlayableCharacter $nonPlayableCharacter
 */
?>
<h1><?= sprintf('%s Timeline Segment (%s)',
    h($nonPlayableCharacter->name),
    $this->Html->link(__('Edit'), ['action' => 'edit', $nonPlayableCharacter->id])
); ?></h1>
<div class="nonPlayableCharacters view large-9 medium-8 columns content">
    <table class="vertical-table">
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
