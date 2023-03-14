<?php
/**
 * @var \App\View\AppView                                                        $this
 * @var \App\Model\Entity\CombatEncounter[]|\Cake\Collection\CollectionInterface $combatEncounters
 */
?>
<div class="combatEncounters index content">
    <h1><?= __('Combat Encounters') ?></h1>
    <div class="form-group">
        <a href="<?= $this->Url->build(
            ['action' => 'add']
        ) ?>" class="btn btn-outline-success"><i class="fa fa-plus"></i><?= __('New Combat Encounter') ?></a>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('campaign_id') ?></th>
            <th class="d-none d-md-table-cell" scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($combatEncounters as $combatEncounter): ?>
            <tr>
                <td><?= $this->Html->link(h($combatEncounter->name), ['action' => 'view', $combatEncounter->id]) ?></td>
                <td><?= $this->Html->link(
                        $combatEncounter->campaign->name,
                        [
                            'controller' => 'Campaigns',
                            'action'     => 'view',
                            $combatEncounter->campaign->id,
                        ]
                    ) ?></td>
                <td class="d-none d-md-table-cell"><?= h($combatEncounter->created) ?></td>
                <td class="actions">
                    <?=
                    $this->Form->postLink(
                        __('Delete'),
                        [
                            'action' => 'delete',
                            $combatEncounter->id,
                        ],
                        [
                            'class'   => ['btn', 'btn-outline-danger'],
                            'confirm' => __('Are you sure you want to delete # {0}?', $combatEncounter->id),
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
