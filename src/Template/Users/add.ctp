<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<h1><?= __('Register') ?></h1>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <?= $this->Form->control('username'); ?>
        <?= $this->Form->control('password'); ?>
        <?= $this->Form->submit(__('Register')) ?>
        <p class="center">Already got an account? <?= $this->Html->link('login', ['action' => 'login']) ?> here!</p>
    </fieldset>
    <?= $this->Form->end() ?>
</div>
