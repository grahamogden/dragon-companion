<?php

use App\Model\Entity\CombatEncounter;
use App\View\AppView;
use \App\View\Widget\AutocompleteToTableWidget;

/**
 * @var AppView         $this
 * @var CombatEncounter $combatEncounter
 * @var array           $campaigns
 * @var array           $combatActions
 */
?>
<?= $this->Html->script('combat-encounters.js') ?>
<div class="combatEncounters form content">
    <h1><?= __('Add Combat Encounter') ?></h1>
    <?= $this->Form->create($combatEncounter) ?>
    <fieldset id="combat-encounters" class="combat-encounter-fieldset">
        <legend>1. Startup</legend>
        <?= $this->Form->control(
            'campaign_id',
            [
                'label'   => __('What campaign is this in?'),
                'class'   => [
                    'form-control',
                ],
                'options' => $campaigns,
            ]
        ) ?>
        <?= $this->Form->control(
            'name',
            [
                'class' => [
                    'form-control',
                ],
            ]
        ) ?>
        <div class="row form-group" role="group" aria-label="">
            <div class="col-md-6 order-md-1">
            </div>
            <div class="col-md-6 order-md-1">
                <?= $this->Form->button(
                    __('Next step'),
                    [
                        'class' => [
                            'btn',
                            'btn-lg',
                            'btn-block',
                            'btn-success',
                            'next-step',
                        ],
                        'type'  => 'button',
                    ]
                ) ?>
            </div>
        </div>
    </fieldset>
    <fieldset id="combat-encounters-participants" class="combat-encounter-fieldset">
        <legend>2. Participants</legend>
        <?= $this->Form->control(
            'player-characters',
            [
                'type'                                       => 'autocomplete-to-table',
                AutocompleteToTableWidget::ATTR_SOURCE       => [
                    AutocompleteToTableWidget::ATTR_SOURCE_ACTION     => 'getAvailablePlayerCharacters',
                    AutocompleteToTableWidget::ATTR_SOURCE_CONTROLLER => 'Participants',
                ],
                'class'                                      => [
                    'form-control',
                    'autocomplete-to-table',
                ],
                AutocompleteToTableWidget::ATTR_HEADING      => 'name',
                AutocompleteToTableWidget::ATTR_CONDITIONALS => [
                    'campaign_id',
                ],
            ]
        ) ?>
        <?= $this->Form->control(
            'monsters',
            [
                'type'                                  => 'autocomplete-to-table',
                AutocompleteToTableWidget::ATTR_SOURCE  => [
                    AutocompleteToTableWidget::ATTR_SOURCE_ACTION     => 'getAvailableMonsters',
                    AutocompleteToTableWidget::ATTR_SOURCE_CONTROLLER => 'Participants',
                ],
                'class'                                 => [
                    'form-control',
                    'autocomplete-to-table',
                ],
                AutocompleteToTableWidget::ATTR_HEADING => 'name',
            ]
        ) ?>
        <div class="row form-group" role="group" aria-label="">
            <div class="col-md-6 order-md-2">
                <?= $this->Form->button(
                    __('Next step'),
                    [
                        'class' => [
                            'btn',
                            'btn-lg',
                            'btn-block',
                            'btn-success',
                            'next-step',
                            'update-initiative-table',
                        ],
                        'type'  => 'button',
                    ]
                ) ?>
            </div>
            <div class="col-md-6 order-md-1">
                <?= $this->Form->button(
                    __('Back'),
                    [
                        'class' => [
                            'btn',
                            'btn-lg',
                            'btn-block',
                            'btn-secondary',
                            'previous-step',
                        ],
                        'type'  => 'button',
                    ]
                ) ?>
            </div>
        </div>
    </fieldset>
    <fieldset id="combat-encounters-participants" class="combat-encounter-fieldset">
        <legend>3. Initiative</legend>
        <table id="initiative-table" class="table table-hover">
            <thead>
            <?= $this->Html->tableHeaders(
                [
                    __('Name'),
                    __('Initiative'),
                    __('AC'),
                    __('Starting HP'),
                ]
            ) ?>
            </thead>
            <tbody></tbody>
        </table>
        <?= $this->Form->control(
            'participants',
            [
                'type' => 'hidden',
            ]
        ) ?>
        <div class="row form-group" role="group" aria-label="">
            <div class="col-md-6 order-md-2">
                <?= $this->Form->button(
                    __('Next step'),
                    [
                        'class' => [
                            'btn',
                            'btn-lg',
                            'btn-block',
                            'btn-success',
                            'next-step',
                            'update-combat-table',
                        ],
                        'type'  => 'button',
                    ]
                ) ?>
            </div>
            <div class="col-md-6 order-md-1">
                <?= $this->Form->button(
                    __('Back'),
                    [
                        'class' => [
                            'btn',
                            'btn-lg',
                            'btn-block',
                            'btn-secondary',
                            'previous-step',
                        ],
                        'type'  => 'button',
                    ]
                ) ?>
            </div>
        </div>
    </fieldset>
    <fieldset id="combat-encounters-combat" class="combat-encounter-fieldset">
        <legend>4. Battle</legend>
        <table id="combat-table" class="table table-hover">
            <thead>
            <?= $this->Html->tableHeaders(
                [
                    __('Name'),
                    __('Init'),
                    __('AC'),
                    __('HP'),
                ]
            ) ?>
            </thead>
            <tbody></tbody>
        </table>
        <h3><?= __('New Turn of Combat') ?></h3>
        <?= $this->Form->control(
            'source-participant',
            [
                'label'   => __('Who'),
                'class'   => ['form-control',],
                'options' => [],
            ]
        ) ?>
        <?= $this->Form->control(
            'combat-actions',
            [
                'label'   => __('Is doing'),
                'class'   => ['form-control',],
                'options' => $combatActions,
            ]
        ) ?>
        <div class="combat-encounter-action-container">
            <div class="combat-encounter-action">
                <?= $this->Form->control(
                    'target-participant',
                    [
                        'label'   => __('The target'),
                        'class'   => ['form-control',],
                        'options' => [],
                    ]
                ) ?>
                <?= $this->Form->control(
                    'combat-roll',
                    [
                        'label'       => 'Roll',
                        'class'       => ['form-control',],
                        'type'        => 'text',
                        'inputmode'   => 'number',
                        'placeholder' => 'd20 + 6 = ?',
                    ]
                ) ?>
                <?= $this->Form->control(
                    'combat-total',
                    [
                        'label'       => 'Total',
                        'class'       => ['form-control',],
                        'type'        => 'text',
                        'inputmode'   => 'number',
                        'placeholder' => 'The total damage/healing done to the target',
                    ]
                ) ?>
                <?= $this->Form->control(
                    'combat-movement',
                    [
                        'label'       => 'Movement',
                        'class'       => ['form-control',],
                        'type'        => 'text',
                        'inputmode'   => 'number',
                        'placeholder' => 'How many spaces moved',
                    ]
                ) ?>
            </div>
        </div>
        <div class="row form-group" role="group" aria-label="">
            <div class="col-12">
                <?= $this->Form->button(
                    'Add another action/target',
                    [
                        'class' => ['btn', 'btn-sm', 'btn-outline-primary',],
                        'type'  => 'button',
                        'id'    => 'add-another-target',
                    ]
                ) ?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <?= $this->Form->button(
                    'End turn',
                    [
                        'class' => [
                            'btn',
                            'btn-sm',
                            'btn-block',
                            'btn-outline-primary',
                        ],
                        'type'  => 'button',
                        'id'    => 'end-of-turn',
                    ]
                ) ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->button(
                    'Round completed',
                    [
                        'class' => [
                            'btn',
                            'btn-sm',
                            'btn-block',
                            'btn-outline-primary',
                        ],
                        'type'  => 'button',
                        'id'    => 'end-of-round',
                    ]
                ) ?>
            </div>
        </div>
        <?= $this->Form->control(
            'turns',
            [
                'class' => ['form-control',],
                'type'  => 'textarea',
                'readonly',
            ]
        ) ?>
        <div class="row form-group" role="group" aria-label="">
            <div class="col-md-6 order-md-2">
                <?= $this->Form->submit(
                    __('Finish!'),
                    [
                        'class' => [
                            'btn',
                            'btn-lg',
                            'btn-block',
                            'btn-success',
                        ],
                    ]
                ) ?>
            </div>
            <div class="col-md-6 order-md-1">
                <?= $this->Form->button(
                    __('Back'),
                    [
                        'class' => [
                            'btn',
                            'btn-lg',
                            'btn-block',
                            'btn-secondary',
                            'previous-step',
                        ],
                        'type'  => 'button',
                    ]
                ) ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->end() ?>
</div>