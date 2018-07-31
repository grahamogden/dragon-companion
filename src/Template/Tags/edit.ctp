<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="tags form large-9 medium-8 columns content">
    <?= $this->Form->create($tag) ?>
    <fieldset>
        <legend><?= __('Edit Tag') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('description');
            echo $this->Form->control('timeline_segments._ids', ['options' => $timelineSegments]);
        ?>
    </fieldset>
    <?= $this->Form->submit(__('Save')) ?>
    <?= $this->Form->end() ?>
</div>
