import { CombatTurnEntity } from '../entities';

export class CombatTurnFormHelper {
    constructor(
        private sourceParticipantElement: HTMLSelectElement,
        private targetParticipantElement: HTMLSelectElement,
        private combatActionsElement: HTMLSelectElement,
        private combatRollElement: HTMLInputElement,
        private combatTotalElement: HTMLInputElement, // private combatMovementElement: HTMLInputElement,
    ) {
        for (let i = 0; i < this.combatActionsElement.options.length; i++) {
            if (this.combatActionsElement.options[i].label === 'ATTACK') {
                this.combatActionsElement.selectedIndex = i; // Set the default action to "ATTACK"
                break;
            }
        }
    }

    // TODO: Break this out - we should be creating the entity in the controller, not here
    public getCombatTurnEntity(roundNumber: number, turnNumber: number) {
        return new CombatTurnEntity(
            parseInt(this.sourceParticipantElement.value.toString()) || 0,
            parseInt(this.targetParticipantElement.value.toString()) || 0,
            this.combatActionsElement.value,
            parseInt(this.combatRollElement.value.toString()) || 0,
            parseInt(this.combatTotalElement.value.toString()) || 0,
            0, //parseInt(this.combatMovementElement.value.toString()) || 0,
            roundNumber,
            turnNumber,
        );
    }

    public setUpNextTurn(participantTemporaryId: number) {
        this.resetValues();
        this.sourceParticipantElement.value = String(participantTemporaryId);
    }

    public resetValues() {
        this.sourceParticipantElement.value = '';
        this.targetParticipantElement.value = '';
        this.combatActionsElement.value = 'ATTACK';
        this.combatRollElement.value = '';
        this.combatTotalElement.value = '';
        // this.combatMovementElement.value = '';
    }
}
