<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CharacterClass[]|\Cake\Collection\CollectionInterface $characterClasses
 */
?>
<div class="characterClasses index content">
    <h1>Character Classes</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($characterClasses as $characterClass): ?>
            <tr>
                <td><?= $this->Number->format($characterClass->id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $characterClass->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $characterClass->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $characterClass->id], ['confirm' => __('Are you sure you want to delete # {0}?', $characterClass->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
