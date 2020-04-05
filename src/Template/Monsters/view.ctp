<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monster $monster
 */
?>
<div class="monsters view content">
    <h1><?= h($monster->name) ?></h1>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($monster->name) ?></td>
        </tr>
    </table>
</div>
