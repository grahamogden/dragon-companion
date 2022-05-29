<?php
use App\Model\Entity\User;
use App\View\AppView;

/**
 * @var AppView $this
 * @var User|null $user
 */

?>
<h1>Register</h1>
<div class="users form content">
    <?= $this->Form->create($user ?? null) ?>
        <fieldset>
            <p class="center">Already got an account? <?= $this->Html->link('login', ['action' => 'login']) ?> here!</p>
            <?= $this->Form->control('username', ['class' => ['form-control']]); ?>
            <?= $this->Form->control('password', ['class' => ['form-control']]); ?>
            <p>Please note, we recommend you do <strong>NOT</strong> use a secure or reused a password from anywhere else for your account here. We currently do <strong>not</strong> use TLS/SSL protection, meaning any data set to or from us is not encrypted and could be intercepted. For this reason, do not put any personal information on this site and do not use anything that can be tied back to yourself, for example, your name, email address, home address, your age, etc. This site is only for role-playing game data, so there should not be anything too personal, identifiable or anything in need of being secured at this time. We will work to get an SSL certificate in the mean time and when we do, we will let you know so you can update your password to something more secure!</p>
            <?= $this->Form->submit('Register', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
