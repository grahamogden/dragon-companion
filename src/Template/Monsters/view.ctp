<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monster $monster
 */
?>
<div class="monsters view content">
    <h1><?= h($monster->name) ?></h1>
    <table class="table table-hover vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($monster->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Max Hit Points') ?></th>
            <td><?= h($monster->max_hit_points) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Armour Class') ?></th>
            <td><?= h($monster->armour_class) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Source') ?></th>
            <td><?= h($monster->data_source->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Source Location') ?></th>
            <td><?= $this->Html->link(h($monster->source_location), h($monster->source_location), ['target' => '_blank']) ?></td>
        </tr>
    </table>
</div>
