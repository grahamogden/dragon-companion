import { TableHelper } from './base-table';
import * as $ from 'jquery';

export class InitiativeTable extends TableHelper {
    /**
     * Table is made up of 4 columns - Name, Initiative, AC, HP
     *
     * @param participant Participantinterface
     */
    addRowToBottom(participant) {
        const randomiserInitiative = this.getRandomiserInitiativeString(
            participant.getDexterityModifier(),
        );
        const randomiserStartingHitPoints =
            this.getRandomizerStartingHitPointString(
                participant.getMaxHitPoints(),
            );
        const initiativeInput = this.getInputInitiative(
            participant.getTempId(),
            participant.getDexterityModifier(),
            participant.getInitiative() ? participant.getInitiative() : '',
        );
        const startingHitPointInput = this.getInputStartingHitPoint(
            participant.getTempId(),
            participant.getMaxHitPoints(),
            participant.getStartingHitPoints(),
        );

        const tableCells =
            `<td>${participant.getName()}</td>` +
            `<td>${initiativeInput}${randomiserInitiative}</td>` +
            `<td>${participant.getArmourClass()}</td>` +
            `<td>${startingHitPointInput}${randomiserStartingHitPoints}</td>`;

        $(this._tableBodies).append(`<tr>${tableCells}</tr>`);
    }

    getRandomiserInitiativeString(dexterityModifier) {
        return `<i class="fas fa-dice-d20 link-fa" onclick="randomiser(jQuery, this, 20, ${dexterityModifier})"></i>`;
    }

    getRandomizerStartingHitPointString(maxHitPoints) {
        return `<i class="fas fa-dice-d20 link-fa" onclick="randomiser(jQuery, this, ${maxHitPoints},  0)"></i>`;
    }

    getInputInitiative(tempId, dexterityModifier, initiative = '') {
        return `<input type="text" inputmode="number" id="participant-initiative-${tempId}" class="participant-initiative" name="participant-initiative[]" value="${initiative}" pattern="\-?[0-9]*" placeholder="(+${dexterityModifier})" />`;
    }

    getInputStartingHitPoint(tempId, maxHitPoints, currentHitPoints = '') {
        return `<input type="text" inputmode="decimal" id="participant-starting-hit-points-${tempId}" class="participant-starting-hit-points" name="participant-starting-hit-points[]" value="${currentHitPoints}" placeholder="${maxHitPoints}" />`;
    }
}
