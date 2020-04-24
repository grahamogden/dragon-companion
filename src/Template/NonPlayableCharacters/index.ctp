<?php
/**
 * @var \App\View\AppView                                                             $this
 * @var \App\Model\Entity\NonPlayableCharacter[]|\Cake\Collection\CollectionInterface $nonPlayableCharacters
 */
?>
<div class="nonPlayableCharacters index content">
    <h1>Non Playable Characters</h1>
    <div class="form-group">
        <a href="<?= $this->Url->build(
            ['action' => 'add']
        ) ?>" class="btn btn-outline-success"><i class="fa fa-plus"></i><?= __('New Non-Playable Character') ?></a>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th><?= sprintf(
                    '%s (%s)',
                    $this->Paginator->sort('name'),
                    $this->Paginator->sort('age')
                ); ?></th>
            <th><?= $this->Paginator->sort('occupation'); ?></th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($nonPlayableCharacters as $nonPlayableCharacter): ?>
            <tr>
                <td><?= sprintf(
                        '%s (%s)',
                        $this->Html->link(
                            $nonPlayableCharacter->name,
                            [
                                'action' => 'edit',
                                $nonPlayableCharacter->id,
                            ]
                        ),
                        $this->Number->format($nonPlayableCharacter->age)
                    ); ?></td>
                <td><?= h($nonPlayableCharacter->occupation); ?></td>
                <td class="actions">
                    <?=
                    $this->Form->postLink(
                        'Delete',
                        [
                            'action' => 'delete',
                            $nonPlayableCharacter->id,
                        ],
                        [
                            'class'   => [
                                'btn',
                                'btn-outline-danger',
                            ],
                            'confirm' => sprintf(
                                'Are you sure you want to delete #%d - %s?',
                                $nonPlayableCharacter->id,
                                $nonPlayableCharacter->title
                            ),
                        ]
                    )
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
