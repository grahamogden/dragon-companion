<h1>Login</h1>
<?= $this->Form->create() ?>
<?= $this->Form->control('username') ?>
<?= $this->Form->control('password') ?>
<?= $this->Form->submit('Login') ?>
<?= $this->Form->end() ?>