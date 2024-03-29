<?php

declare(strict_types=1);

use App\View\AppView;
use App\Model\Entity\Campaign;
use Cake\Collection\CollectionInterface;

/**
 * @var AppView $this
 * @var Campaign[]|CollectionInterface $campaigns
 */
?>
<div class="campaigns index content">
    <h1><?= __('Campaigns') ?></h1>
    <p>Welcome to Campaigns! From here, you can create a new campaign and fill it with all of the timeline segments that
        make it up.</p>
    <div class="form-group">
        <a href="<?= $this->Url->build(
                        ['action' => 'add']
                    ) ?>" class="btn btn-outline-success"><i class="fa fa-plus"></i><?= __('New Campaign') ?></a>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th class="d-none d-md-table-cell" scope="col"><?= __('Synopsis') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($campaigns as $campaign) : ?>
                <tr>
                    <td><?= $this->Html->link(
                            h($campaign->name),
                            [
                                'action' => 'edit',
                                $campaign->id
                            ]
                        ) ?></td>
                    <td class="d-none d-md-table-cell"><?= h($campaign->synopsis) ?></td>
                    <td class="actions">
                        <?= $this->Form->postLink(
                            __('Select'),
                            ['action' => 'selectCampaign', $campaign->id],
                            [
                                'class'   => [
                                    'btn',
                                    'btn-outline-primary',
                                ],
                            ]
                        )
                        ?><?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $campaign->id],
                                [
                                    'class'   => [
                                        'btn',
                                        'btn-outline-danger',
                                    ],
                                    'confirm' => __('Are you sure you want to delete # {0}?', $campaign->id),
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