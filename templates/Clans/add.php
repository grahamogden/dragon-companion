<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clan $clan
 */
?>
<div class="clans form content">
    <h1>Create a Clan</h1>
    <?= $this->Form->create($clan) ?>
        <fieldset>
            <?= $this->Form->control('name', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('description', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('users._ids', ['options' => $users, 'class' => ['form-control']]) ?>
        </fieldset>
        <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
