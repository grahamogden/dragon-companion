<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<h1>Login</h1>
<div class="timelineSegments form content">
    <?= $this->Form->create(); ?>
        <fieldset>
            <p class="center">Not got a login? <?= $this->Html->link('register', ['controller' => 'Users', 'action' => 'add']) ?> here!</p>
            <?= $this->Form->control('username', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('password', ['class' => ['form-control']]) ?>
            <?= $this->Form->submit('Login', ['class' => ['btn','btn-lg','btn-block btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>