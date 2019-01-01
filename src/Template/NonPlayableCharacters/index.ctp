<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonPlayableCharacter[]|\Cake\Collection\CollectionInterface $nonPlayableCharacters
 */
?>
<div class="nonPlayableCharacters index large-9 medium-8 columns content">
    <h3><?= __('Non Playable Characters') ?></h3>
    <?= $this->Html->link(__('New Non Playable Character'), ['action' => 'add']) ?>
    <table>
        <thead>
            <tr>
                <th scope="col"><?= sprintf(
                    '%s (%s)',
                    $this->Paginator->sort('name'),
                    $this->Paginator->sort('age')
                ); ?></th>
                <th scope="col"><?= $this->Paginator->sort('occupation'); ?></th>
                <th scope="col"><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nonPlayableCharacters as $nonPlayableCharacter): ?>
                <tr>
                    <td><?= sprintf(
                        '%s (%s)',
                        $this->Html->link($nonPlayableCharacter->name, [
                            'action' => 'edit',
                            $nonPlayableCharacter->id,
                        ]),
                        $this->Number->format($nonPlayableCharacter->age)
                    ); ?></td>
                    <td><?= h($nonPlayableCharacter->occupation); ?></td>
                    <td class="actions">
                        <ul class="menu">
                            <!-- <li><?= $this->Html->link('', [
                                'action' => 'edit',
                                $nonPlayableCharacter->id
                            ], [
                                'class'   => [
                                    'action',
                                    'button',
                                    'edit-button'
                                ],
                            ]); ?></li> -->
                            <li><?= $this->Form->postLink('', [
                                'action' => 'delete',
                                $nonPlayableCharacter->id
                            ], [
                                'class'   => [
                                    'action',
                                    'button',
                                    'delete-button'
                                ],
                                'confirm' => __('Are you sure you want to delete # {0}?', $nonPlayableCharacter->id),
                            ]); ?></li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('pagination') ?>
</div>
