<?php

use App\Model\Entity\Campaign;
use App\View\AppView;

/**
 * @var AppView  $this
 * @var Campaign $campaign
 */
?>
<div class="campaigns form content">
    <h1><?= __('Add Campaign') ?></h1>
    <?= $this->Form->create($campaign) ?>
        <fieldset>
            <?= $this->Form->control('name', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('synopsis', ['class' => ['form-control'], 'type' => 'textarea']) ?>
        </fieldset>
        <?= $this->Form->submit('Save', ['class' => ['btn', 'btn-lg', 'btn-block', 'btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
