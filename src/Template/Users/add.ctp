<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<h1>Register</h1>
<div class="users form content">
    <?= $this->Form->create($user) ?>
        <fieldset>
            <p class="center">Already got an account? <?= $this->Html->link('login', ['action' => 'login']) ?> here!</p>
            <?= $this->Form->control('username', ['class' => ['form-control']]); ?>
            <?= $this->Form->control('password', ['class' => ['form-control']]); ?>
            <?= $this->Form->submit('Register', ['class' => ['btn','btn-lg','btn-block btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
