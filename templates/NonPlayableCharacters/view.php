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
    <table class="table vertical-table">
        <tr>
            <th>Occupation</th>
            <td><?= h($nonPlayableCharacter->occupation) ?></td>
        </tr>
        <tr>
            <th>Tag</th>
            <td><?= $nonPlayableCharacter->has('tag')
                ? $this->Html->link(
                    $nonPlayableCharacter->tag->title,
                    ['controller' => 'Tags', 'action' => 'view', $nonPlayableCharacter->tag->id]
                )
                : '' ?></td>
        </tr>
        <tr>
            <th>Id</th>
            <td><?= $this->Number->format($nonPlayableCharacter->id) ?></td>
        </tr>
        <tr>
            <th>Age</th>
            <td><?= $this->Number->format($nonPlayableCharacter->age) ?></td>
        </tr>
        <tr>
            <th>Alignment</th>
            <td><?= __($nonPlayableCharacter->alignment->name) ?></td>
        </tr>
        <tr>
            <th>Appearance</th>
            <td><?= $this->Text->autoParagraph(h($nonPlayableCharacter->appearance)); ?></td>
        </tr>
        <tr>
            <th>Personality</th>
            <td><?= $this->Text->autoParagraph(h($nonPlayableCharacter->personality)); ?></td>
        </tr>
        <tr>
            <th>History</th>
            <td><?= $this->Text->autoParagraph(h($nonPlayableCharacter->history)); ?></td>
        </tr>
        <tr>
            <th>Notes</th>
            <td><?= $this->Text->autoParagraph(h($nonPlayableCharacter->notes)); ?></td>
        </tr>
    </table>
</div>
