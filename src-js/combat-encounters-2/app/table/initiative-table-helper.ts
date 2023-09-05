import { TableHelper } from './base-table';
import { ParticipantAbstract } from '../entities';
import { InitiativeTableOutputDto } from '../helpers/dto';

export class InitiativeTableHelper extends TableHelper {
    private readonly KEY_DATA_TEMPORARY_ID = 'data-temporary-id';

    /**
     * Table is made up of 4 columns - Name, Initiative, AC, HP
     */
    public addInitiativeRow(participant: ParticipantAbstract) {
        console.debug(`Add initiative row`);
        console.debug(participant);
        const randomizerInitiative = this.getRandomizerInitiativeString(
            participant.dexterityModifier,
        );
        const randomizerStartingHitPoints =
            this.getRandomizerStartingHitPointString(participant.maxHitPoints);
        const initiativeInput = this.getInputInitiative(
            participant.temporaryId,
            participant.dexterityModifier,
            participant.initiative as number,
        );
        const startingHitPointInput = this.getInputStartingHitPoint(
            participant.temporaryId,
            participant.maxHitPoints,
            participant.currentHitPoints,
        );

        const tableCells =
            `<td>${participant.participantName}</td>` +
            `<td>${initiativeInput}${randomizerInitiative}</td>` +
            `<td>${participant.armourClass}</td>` +
            `<td>${startingHitPointInput}${randomizerStartingHitPoints}</td>`;

        this.addRowToBottom(tableCells);
    }

    private getRandomizerInitiativeString(dexterityModifier: number) {
        return `<i class="fas fa-dice-d20 link-fa randomiser" onclick="/*randomiser(this, 20, ${dexterityModifier})*/" data-max="20" data-modifier="${dexterityModifier}"></i>`;
    }

    private getRandomizerStartingHitPointString(maxHitPoints: number) {
        return `<i class="fas fa-dice-d20 link-fa randomiser" onclick="/*randomiser(this, ${maxHitPoints},  0)*/" data-max="${maxHitPoints}" data-modifier="0"></i>`;
    }

    private getInputInitiative(
        temporaryId: number,
        dexterityModifier: number,
        initiative: number,
    ) {
        return (
            `<input type='text' inputmode='number' ` +
            `${this.KEY_DATA_TEMPORARY_ID}=${temporaryId} ` +
            `id='participant-initiative-${temporaryId}' ` +
            `class='participant-initiative' name='participant-initiative[]' ` +
            `value='${initiative}' pattern='\-?[0-9]*' ` +
            `placeholder='(+${dexterityModifier})' />`
        );
    }

    private getInputStartingHitPoint(
        temporaryId: number,
        maxHitPoints: number,
        currentHitPoints: number,
    ) {
        return (
            `<input type='text' inputmode='decimal' ` +
            `${this.KEY_DATA_TEMPORARY_ID}=${temporaryId} ` +
            `id='participant-starting-hit-points-${temporaryId}' ` +
            `class='participant-starting-hit-points' ` +
            `name='participant-starting-hit-points[]' ` +
            `value='${currentHitPoints}' placeholder='${maxHitPoints}' />`
        );
    }

    public getAllParticipantInitiativesAndHitPointsPerIds(): InitiativeTableOutputDto[] {
        const participantInitiativeAndHitPoints: InitiativeTableOutputDto[] =
            [];
        const initiativeInputs = this._tableBodies[0].querySelectorAll(
            '.participant-initiative',
        ) as NodeListOf<HTMLInputElement>;
        initiativeInputs.forEach((initiativeInput) => {
            const participantTemporaryId =
                initiativeInput.getAttribute(this.KEY_DATA_TEMPORARY_ID) ??
                null;
            if (null === participantTemporaryId) {
                console.debug(
                    `${this.KEY_DATA_TEMPORARY_ID} not found for initiative, skipping`,
                );
            } else {
                participantInitiativeAndHitPoints.push({
                    temporaryId: Number(participantTemporaryId),
                    initiative: Number(initiativeInput.value),
                });
            }
        });

        const startingHitPointInputs = this._tableBodies[0].querySelectorAll(
            '.participant-starting-hit-points',
        ) as NodeListOf<HTMLInputElement>;
        startingHitPointInputs.forEach((startingHitPointInput) => {
            const participantTemporaryId = startingHitPointInput
                .getAttribute(this.KEY_DATA_TEMPORARY_ID)
                ?.toString();
            if (null === participantTemporaryId) {
                console.debug(
                    `${this.KEY_DATA_TEMPORARY_ID} not found for starting hit points, skipping`,
                );
            } else {
                participantInitiativeAndHitPoints.forEach(
                    (participantInitiativeAndHitPoint) => {
                        participantInitiativeAndHitPoint.startingHitPoints =
                            Number(startingHitPointInput.value);
                    },
                );
            }
        });

        return participantInitiativeAndHitPoints;
    }
}
