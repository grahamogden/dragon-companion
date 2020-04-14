<?php

use App\Model\Entity\CombatEncounter;
use App\View\AppView;
use \App\View\Widget\AutocompleteToTableWidget;

/**
 * @var AppView         $this
 * @var CombatEncounter $combatEncounter
 * @var array           $campaigns
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
        <?= $this->Form->button(
            __('Next step'),
            [
                'class' => [
                    'btn',
                    'btn-lg',
                    'btn-block',
                    'btn-success',
                    'next-step',
                    'update-participants',
                ],
                'type'  => 'button',
            ]
        ) ?>
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
    </fieldset>
    <fieldset id="combat-encounters-participants" class="combat-encounter-fieldset">
        <legend>3. Initiative</legend>
        <table id="initiative-table" class="table table-hover">
            <thead>
            <?= $this->Html->tableHeaders(
                [
                    __('Name'),
                    __('Initiative'),
                    __('Armour Class'),
                    __('Hit Points'),
                ]
            ) ?>
            </thead>
            <tbody></tbody>
        </table>
        <?= $this->Form->control(
            'participants',
            [
                'type' => 'textarea',
            ]
        ) ?>
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
    </fieldset>
    <fieldset id="combat-encounters-combat" class="combat-encounter-fieldset">
        <legend>4. Battle</legend>
        <?= $this->Form->control(
            'turns',
            [
                'class' => ['form-control',],
                'type'  => 'textarea',
                'readonly',
            ]
        ) ?>
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
    </fieldset>
    <?= $this->Form->end() ?>
</div>