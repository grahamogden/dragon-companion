<?php

use App\Model\Entity\Tag;
use App\View\AppView;

/**
 * @var AppView $this
 * @var Tag     $tag
 * @var array   $timelineSegments
 */
?>
<div class="tags form content">
    <h1><?= __('Edit Tag') ?></h1>
    <?= $this->Form->create($tag) ?>
    <fieldset>
        <?= $this->Form->control('title', ['class' => ['form-control']]) ?>
        <?= $this->Form->control('description', ['class' => ['form-control']]) ?>
        <?php /* echo $this->Form->control(
            'timeline_segments._ids',
            [
                'class'   => ['form-control'],
                'options' => $timelineSegments,
            ]
        ) */ ?>
        <?= $this->Form->submit(__('Save'), ['class' => ['btn', 'btn-block', 'btn-lg', 'btn-success',]]) ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>
