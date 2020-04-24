<?php
/**
 * @var \App\View\AppView                                                        $this
 * @var \App\Model\Entity\PlayerCharacter[]|\Cake\Collection\CollectionInterface $playerCharacters
 */
?>
<div class="playerCharacters index content">
    <h1>Player Characters</h1>
    <div class="form-group">
        <a href="<?= $this->Url->build(
            ['action' => 'add']
        ) ?>" class="btn btn-outline-success"><i class="fa fa-plus"></i><?= __('New Player Character') ?></a>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('first_name', 'Name') ?></th>
            <th class="d-none d-md-table-cell" scope="col"><?= __('Age') ?></th>
            <th class="d-none d-md-table-cell" scope="col"><?= __('Max HP') ?></th>
            <th class="d-none d-md-table-cell" scope="col"><?= __('Armour Class') ?></th>
            <th scope="col"><?= __('Campaign') ?></th>
            <th scope="col" class="actions">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($playerCharacters as $playerCharacter): ?>
            <tr>
                <td><?= $this->Html->link(
                        h($playerCharacter->first_name) . ' ' . h($playerCharacter->last_name),
                        ['action' => 'view', $playerCharacter->id]
                    ) ?></td>
                <td class="d-none d-md-table-cell"><?= $this->Number->format($playerCharacter->age) ?></td>
                <td class="d-none d-md-table-cell"><?= $this->Number->format($playerCharacter->max_hit_points) ?></td>
                <td class="d-none d-md-table-cell"><?= $this->Number->format($playerCharacter->armour_class) ?></td>
                <td><?= h($playerCharacter->campaign->name) ?></td>
                <td class="actions">
                    <?=
                    $this->Html->link(
                        __('Edit'),
                        [
                            'action' => 'edit',
                            $playerCharacter->id,
                        ],
                        [
                            'class' => ['btn', 'btn-outline-primary'],
                        ]
                    )
                    ?><?=
                    $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $playerCharacter->id],
                        [
                            'class'   => ['btn', 'btn-outline-danger'],
                            'confirm' => __(
                                'Are you sure you want to delete # {0}?',
                                $playerCharacter->id
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
