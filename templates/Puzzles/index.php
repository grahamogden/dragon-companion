<?php
/**
 * @var \App\View\AppView                                               $this
 * @var \App\Model\Entity\Puzzle[]|\Cake\Collection\CollectionInterface $puzzles
 */
?>
<div class="puzzles index content">
    <h1>Puzzles</h1>
    <div class="form-group">
        <a href="<?= $this->Url->build(
            ['action' => 'add']
        ) ?>" class="btn btn-outline-success"><i class="fa fa-plus"></i><?= __('New Puzzle') ?></a>
    </div>
    <table class="table table-hover" cellpadding="0" cellspacing="0">
        <thead class="thead-light">
        <tr>
            <th scope="col"><?= $this->Paginator->sort('title') ?></th>
            <th scope="col"><?= $this->Paginator->sort('description') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($puzzles as $puzzle): ?>
            <tr>
                <td><?= $this->Html->link(h($puzzle->title), ['action' => 'edit', $puzzle->id]) ?></td>
                <td><?= h($puzzle->description) ?></td>
                <td class="actions">
                    <?=
                    $this->Html->link(
                        'Present',
                        ['action' => 'view', $puzzle->id],
                        ['class' => ['btn', 'btn-outline-primary']]
                    )
                    ?><?=
                    $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $puzzle->id],
                        [
                            'confirm' => sprintf(
                                'Are you sure you want to delete #%d - %s?',
                                $puzzle->id,
                                $puzzle->title
                            ),
                            'class'   => ['btn', 'btn-outline-danger'],
                        ]
                    )
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination'); ?>
</div>