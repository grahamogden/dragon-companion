<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Campaign $campaign
 */
?>
<div class="campaigns view content">
    <h1><?= h($campaign->name) ?></h1>
    <table class="table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= h($campaign->user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($campaign->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Synopsis') ?></th>
            <td><?= h($campaign->synopsis) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Clan') ?></th>
            <td><?= h($campaign->clan->name) ?></td>
        </tr>
    </table>
</div>
