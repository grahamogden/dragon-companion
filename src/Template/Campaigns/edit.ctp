<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Campaign $campaign
 */
?>
<div class="campaigns form content">
    <h1><?= __('Edit Campaign') ?></h1>
    <?= $this->Form->create($campaign) ?>
        <fieldset>
            <?= $this->Form->control('name', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('synopsis', ['class' => ['form-control'], 'type' => 'textarea']) ?>
            <?= $this->Form->control('clan_id', ['class' => ['form-control'], 'options' => $clans, 'empty' => true]) ?>
        </fieldset>
        <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
