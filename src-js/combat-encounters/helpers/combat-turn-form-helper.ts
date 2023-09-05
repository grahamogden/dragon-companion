import { CombatTurnEntity } from '../entities/combat-turn';
import $ from 'jquery';
import { ParticipantAbstract } from '../entities/participant-abstract';

export class CombatTurnFormHelper {
    constructor(
        private sourceParticipantElement: HTMLSelectElement,
        private targetParticipantElement: HTMLSelectElement,
        private combatActionsElement: HTMLSelectElement,
        private combatRollElement: HTMLInputElement,
        private combatTotalElement: HTMLInputElement,
        private combatMovementElement: HTMLInputElement,
        private participants: ParticipantAbstract[],
    ) {
        for (let i = 0; i < this.combatActionsElement.options.length; i++) {
            if (this.combatActionsElement.options[i].label === 'ATTACK') {
                this.combatActionsElement.selectedIndex = i; // Set the default action to "ATTACK"
                break;
            }
        }

        this.addParticipantOptionsToSelect(
            participants,
            this.sourceParticipantElement,
        );

        this.addParticipantOptionsToSelect(
            participants,
            this.targetParticipantElement,
        );

        this.setUpNextTurn(participants[0].getTemporaryId());
    }

    private addParticipantOptionsToSelect(
        participants: ParticipantAbstract[],
        selectElement: HTMLSelectElement,
    ) {
        while (selectElement.options.length > 0) {
            selectElement.remove(0);
        }
        selectElement.append('<option value="">No source</option>');

        $.each(participants, function (index, participant) {
            $(selectElement).append(
                `<option value="${participant.getTemporaryId()}">${
                    participant.participantName
                }</option>`,
            );
        });
    }

    getCombatTurnEntity(roundNumber: number, turnNumber: number) {
        return new CombatTurnEntity(
            parseInt(this.sourceParticipantElement.value.toString()) || 0,
            parseInt(this.targetParticipantElement.value.toString()) || 0,
            this.combatActionsElement.value,
            parseInt(this.combatRollElement.value.toString()) || 0,
            parseInt(this.combatTotalElement.value.toString()) || 0,
            parseInt(this.combatMovementElement.value.toString()) || 0,
            roundNumber,
            turnNumber,
        );
    }

    setUpNextTurn(participantTemporaryId: number) {
        this.resetValues();
        this.sourceParticipantElement.value = String(participantTemporaryId);
    }

    resetValues() {
        this.sourceParticipantElement.value = '';
        this.targetParticipantElement.value = '';
        this.combatActionsElement.value = 'ATTACK';
        this.combatRollElement.value = '';
        this.combatTotalElement.value = '';
        this.combatMovementElement.value = '';
    }
}
