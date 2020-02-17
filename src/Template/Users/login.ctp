<h1>Login</h1>
<div class="timelineSegments form large-9 medium-8 columns content">
    <?= $this->Form->create(); ?>
        <fieldset>
            <?= $this->Form->control('username') ?>
            <?= $this->Form->control('password') ?>
            <?= $this->Form->submit('Login') ?>
            <p class="center">Not got a login? <?= $this->Html->link('register', ['action' => 'register']) ?> here!</p>
        </fieldset>
    <?= $this->Form->end() ?>
</div>