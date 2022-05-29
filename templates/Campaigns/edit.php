<?php

use \App\View\Widget\AutocompleteToTableWidget;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Campaign $campaign
 */
?>
<div class="campaigns form content">
    <h1><?= __('Edit Campaign') ?></h1>
    <?= $this->Form->create($campaign) ?>
        <fieldset>
            <?= $this->Form->control('name', ['class' => ['form-control']]) ?>
            <?= $this->Form->control('synopsis', ['class' => ['form-control'], 'type' => 'textarea']) ?>
            <?= $this->Form->control(
                'users_string',
                [
                    'label'         => 'Users',
                    'type'          => 'autocomplete-to-table',
                    AutocompleteToTableWidget::ATTR_SOURCE => [
                        'prefix'     => 'api/v1',
                        AutocompleteToTableWidget::ATTR_SOURCE_CONTROLLER => 'users',
                        'action'     => 'get-users',
                        '_method'     => 'get',
                    ],
                    'class'         => ['form-control autocomplete-to-table'],
                    AutocompleteToTableWidget::ATTR_HEADING => 'name',
                    AutocompleteToTableWidget::ATTR_VALUE => $campaignUsers->toArray(),
                ]
            ) ?>
        </fieldset>
        <?= $this->Form->submit('Save', ['class' => ['btn','btn-lg','btn-block','btn-success']]) ?>
    <?= $this->Form->end() ?>
</div>
