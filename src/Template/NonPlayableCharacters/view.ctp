<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonPlayableCharacter $nonPlayableCharacter
 */
?>
<h1><?= sprintf('%s Timeline Segment (%s)',
    h($nonPlayableCharacter->name),
    $this->Html->link('Edit', ['action' => 'edit', $nonPlayableCharacter->id])
); ?></h1>
<div class="nonPlayableCharacters view content">
    <table class="vertical-table">
        <tr>
            <th scope="row">Occupation</th>
            <td><?= h($nonPlayableCharacter->occupation) ?></td>
        </tr>
        <tr>
            <th scope="row">Tag</th>
            <td><?= $nonPlayableCharacter->has('tag')
                ? $this->Html->link(
                    $nonPlayableCharacter->tag->title,
                    ['controller' => 'Tags', 'action' => 'view', $nonPlayableCharacter->tag->id]
                )
                : '' ?></td>
        </tr>
        <tr>
            <th scope="row">Id</th>
            <td><?= $this->Number->format($nonPlayableCharacter->id) ?></td>
        </tr>
        <tr>
            <th scope="row">Age</th>
            <td><?= $this->Number->format($nonPlayableCharacter->age) ?></td>
        </tr>
        <tr>
            <th scope="row">Alignment</th>
            <td><?= $this->Number->format($nonPlayableCharacter->alignment) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4>Appearance</h4>
        <?= $this->Text->autoParagraph(h($nonPlayableCharacter->appearance)); ?>
    </div>
    <div class="row">
        <h4>Personality</h4>
        <?= $this->Text->autoParagraph(h($nonPlayableCharacter->personality)); ?>
    </div>
    <div class="row">
        <h4>History</h4>
        <?= $this->Text->autoParagraph(h($nonPlayableCharacter->history)); ?>
    </div>
    <div class="row">
        <h4>Notes</h4>
        <?= $this->Text->autoParagraph(h($nonPlayableCharacter->notes)); ?>
    </div>
</div>
