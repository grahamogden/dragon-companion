import { TableHelper } from './base-table';
import * as $ from 'jquery';
import { ParticipantAbstract } from '../entities/participant-abstract';

export class CombatTable extends TableHelper {
    /**
     * Table is made up of 4 columns - Name, Initiative, AC, HP
     *
     * @param participant
     */
    addRowToBottom(participant: ParticipantAbstract) {
        console.log(participant);
        const tableCells =
            `<td>${participant.getName()}</td>` +
            `<td>${participant.getInitiative()}</td>` +
            `<td>${participant.getArmourClass()}</td>` +
            `<td><span class="hit-points">${participant.getCurrentHitPoints()}</span> <span class="text-secondary">(${participant.getMaxHitPoints()})</span></td>`;

        this.table.append(
            `<tr class="combat-participant-${participant.getTemporaryId()}">${tableCells}</tr>`,
        );
    }

    getHitPointText(currentHitPoints: number) {
        return `${currentHitPoints} `;
    }

    selectTableRowForParticipantTemporaryId(tempId: number) {
        const activeRowClass = 'combat-turn-active';
        $(this._tableBodies).find('tr').removeClass(activeRowClass);
        $(this._tableBodies)
            .find('.combat-participant-' + tempId)
            .addClass(activeRowClass);
    }

    updateHitPointsForParticipantTempId(participant: ParticipantAbstract) {
        $(
            '.combat-participant-' +
                participant.getTemporaryId() +
                ' .hit-points',
        ).text(this.getHitPointText(participant.getCurrentHitPoints() ?? 0));
    }
}
