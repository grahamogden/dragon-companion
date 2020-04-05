<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monster $monster
 */
?>
<div class="monsters form content">
    <h1>Edit Monster - <?= $monster->name ?></h1>
    <?= $this->Form->create($monster) ?>
        <fieldset>
            <?= $this->Form->control('name') ?>
                <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>
