import { TableHelper } from './base-table';
import { ParticipantAbstract } from '../entities';
import { NotFoundException } from '../exceptions';

export class CombatTableHelper extends TableHelper {
    /**
     * Table is made up of 4 columns - Name, Initiative, AC, HP
     *
     * @param participant
     */
    addParticipantRow(participant: ParticipantAbstract) {
        const tableCells =
            `<td>${participant.participantName}</td>` +
            `<td>${participant.initiative}</td>` +
            `<td>${participant.armourClass}</td>` +
            `<td><span class='hit-points'>${participant.currentHitPoints}</span> <span class='text-secondary'>(${participant.maxHitPoints})</span></td>`;

        this.addRowToBottom(`<tr >${tableCells}</tr>`, [
            `combat-participant-${participant.temporaryId}`,
        ]);
    }

    public selectTableRowForParticipantTemporaryId(temporaryId: number) {
        const activeRowClass = 'combat-turn-active';
        const i = 0;
        // for (let i = 0; i < this._tableBodies.length; i++) {
        const tableRows = this._tableBodies[i].querySelectorAll('tr');
        for (let j = 0; j < tableRows.length; j++) {
            tableRows[j].classList.remove(activeRowClass);
        }

        const participantRow = this._tableBodies[i].querySelector(
            '.combat-participant-' + temporaryId,
        ) as HTMLTableRowElement;
        participantRow.classList.add(activeRowClass);
    }

    public updateHitPointsForParticipantTempId(
        participant: ParticipantAbstract,
    ) {
        console.debug('Updating hit point:');
        const hitPointsElement = this._tableBodies[0].querySelector(
            `.combat-participant-${participant.temporaryId} .hit-points`,
        ) as HTMLTableRowElement | null;
        console.debug(hitPointsElement);
        if (null === hitPointsElement) {
            throw new NotFoundException(
                `combat-participant-${participant.temporaryId} .hit-points not found`,
            );
        }

        console.debug(`${participant.currentHitPoints}`);
        hitPointsElement.innerText = `${participant.currentHitPoints}`;
    }
}
