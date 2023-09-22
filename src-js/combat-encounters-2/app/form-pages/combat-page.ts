import { FormPage } from '../form-helper/form-page';
import { CombatEncounterHandler } from '../combat-encounter-handler';
import { NotFoundException } from '../exceptions';
import { CombatTableHelper } from '../table';
import { ParticipantAbstract } from '../entities';
import { FormPageInterface } from '../form-helper';

export class CombatPage extends FormPage implements FormPageInterface {
    public static readonly PAGE_ID = 'combat-encounters-combat';
    constructor(
        private readonly _combatEncounter: CombatEncounterHandler,
        private readonly _combatTableHelper: CombatTableHelper,
    ) {
        super(CombatPage.PAGE_ID);
        // $('.update-combat-table').on('click', function (event) {
        //     event.preventDefault();
        //     const $tableBody = $('#combat-table tbody');
        //
        //     combatTableHelper.clearTable();
        //
        //     setParticipantStartingValuesOnCombatEncounter();
        //     participantJsonHelper.updateParticipantJson(
        //         combatEncounter.getParticipants(),
        //     );
        //     combatEncounter.setUpCombat();
        // });
        this.initAddAnotherTargetButton();
        this.initEndOfTurnButton();
        this.initEndOfRoundButton();
        this.initEndOfGameButton();
    }

    private initAddAnotherTargetButton() {
        const self = this.getSelf();
        const addAnotherTurnButton = this._fieldset.querySelector(
            '#add-another-target',
        ) as HTMLButtonElement | null;

        if (null === addAnotherTurnButton) {
            throw new NotFoundException('#add-another-target button not found');
        }

        addAnotherTurnButton.addEventListener('click', (event) => {
            event.preventDefault();
            console.debug('Add another target');
            self._combatEncounter.addAnotherTarget(self._combatTableHelper);
        });
    }

    private initEndOfTurnButton() {
        const self = this.getSelf();
        const endOfTurnButton = this._fieldset.querySelector(
            '#end-of-turn',
        ) as HTMLButtonElement | null;

        if (endOfTurnButton === null) {
            throw new NotFoundException('#end-of-turn button not found');
        }

        endOfTurnButton.addEventListener('click', (event) => {
            event.preventDefault();
            console.debug('End of turn');
            self._combatEncounter.addTurnOfCombat(self._combatTableHelper);
        });
    }

    private initEndOfRoundButton() {
        const self = this.getSelf();
        const endOfRoundButton = this._fieldset.querySelector(
            '#end-of-round',
        ) as HTMLButtonElement | null;

        if (endOfRoundButton === null) {
            throw new NotFoundException('#end-of-round button not found');
        }

        endOfRoundButton.addEventListener('click', (event) => {
            event.preventDefault();
            console.debug('End of round');
            self._combatEncounter.startNewRound(self._combatTableHelper);
        });
    }

    private initEndOfGameButton() {
        const self = this.getSelf();
        const form = document.querySelector('form') as HTMLFormElement | null;

        if (form === null) {
            throw new NotFoundException('#end-of-turn button not found');
        }

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            console.debug('End of game');

            if (!confirm('Has the battle finished?!')) {
                return false;
            }

            self._combatEncounter.endCombat();
            self._combatEncounter.clearEncounter();
            form.submit();
        });
    }

    buildForm() {
        const participants = this._combatEncounter.getParticipants();

        participants.sort(function (a, b) {
            return (b.initiative ?? 0) - (a.initiative ?? 0);
        });

        participants.forEach((participant) => {
            this._combatTableHelper.addParticipantRow(participant);
        });
        this.updateParticipantSelects(this._combatEncounter.getParticipants());

        // this._combatTableHelper.selectTableRowForParticipantTemporaryId(
        //     participants[0].temporaryId,
        // );

        // if (this._combatEncounter.)
        // Select the first participant
        this._combatEncounter.startNewRound(this._combatTableHelper);
    }

    action(): void {
        return;
    }

    isValid(): string[] {
        return [];
    }

    private updateParticipantSelects(participants: ParticipantAbstract[]) {
        const sourceParticipantSelect = this._fieldset.querySelector(
            'select#source-participant',
        ) as HTMLSelectElement | null;
        console.debug(this._fieldset);
        console.debug(sourceParticipantSelect);
        if (null === sourceParticipantSelect) {
            throw new NotFoundException(
                'sourceParticipantSelect could not be found',
            );
        }
        this.updateParticipantSelect(participants, sourceParticipantSelect);

        const targetParticipantSelect = this._fieldset.querySelector(
            'select#target-participant',
        ) as HTMLSelectElement | null;
        if (null === targetParticipantSelect) {
            throw new NotFoundException(
                'targetParticipantSelect could not be found',
            );
        }
        this.updateParticipantSelect(participants, targetParticipantSelect);
    }

    private updateParticipantSelect(
        participants: ParticipantAbstract[],
        selectElement: HTMLSelectElement,
    ) {
        while (selectElement.options.length > 0) {
            selectElement.remove(0);
        }
        const noSourceOption = new Option('No one');
        selectElement.appendChild(noSourceOption); //'<option value="">No source</option>');

        for (const participant of participants) {
            console.debug(JSON.stringify(participant));
            console.debug(JSON.stringify(participant.temporaryId));
            console.debug(participant.temporaryId.toString());
            const option = new Option(
                participant.participantName,
                participant.temporaryId.toString(),
            );
            selectElement.appendChild(option); //`<option value='${}'>${}</option>`);
        }
    }
}
