import { FormPage } from '../form-helper/form-page';
import { CombatEncounterHandler } from '../combat-encounter-handler';
import { Randomiser } from '../helpers/randomiser';
import { InitiativeTableHelper } from '../table';
import { FormPageInterface } from '../form-helper';

export class InitiativePage extends FormPage implements FormPageInterface {
    public static readonly PAGE_ID = 'combat-encounters-initiative';

    constructor(
        private readonly _combatEncounter: CombatEncounterHandler,
        private readonly initiativeTable: InitiativeTableHelper,
        private readonly randomiser: Randomiser,
    ) {
        super(InitiativePage.PAGE_ID);
    }

    private initRandomisers() {
        const self = this.getSelf();
        const randomiserElements =
            this._fieldset.querySelectorAll('i.randomiser');

        randomiserElements.forEach((randomiserElement) => {
            randomiserElement.addEventListener('click', function (event) {
                event.preventDefault();
                const input =
                    randomiserElement.previousElementSibling as HTMLInputElement;
                input.value = String(
                    self.randomiser.randomise(
                        Number(randomiserElement.getAttribute('data-max')) ?? 0,
                        Number(
                            randomiserElement.getAttribute('data-modifier'),
                        ) ?? 0,
                    ),
                );
            });
        });
    }

    buildForm() {
        console.debug('Building initiative page');
        this.initiativeTable.clearTable();

        const participants = this._combatEncounter.getParticipants();
        console.debug(participants);
        for (const participant of participants) {
            this.initiativeTable.addInitiativeRow(participant);
            // combatEncounter.addParticipant(participants[i]);
        }

        this.initRandomisers();
    }

    action(): void {
        const participantInitiativesAndHitPoints =
            this.initiativeTable.getAllParticipantInitiativesAndHitPointsPerIds();
        const participants = this._combatEncounter.getParticipants();
        this._combatEncounter.clearParticipants();

        participants.forEach((participant) => {
            participantInitiativesAndHitPoints.forEach(
                (participantInitiativesAndHitPoint) => {
                    if (
                        participant.temporaryId ===
                        participantInitiativesAndHitPoint.temporaryId
                    ) {
                        if (
                            typeof participantInitiativesAndHitPoint.initiative !==
                            'undefined'
                        ) {
                            participant.initiative =
                                participantInitiativesAndHitPoint.initiative;
                        }

                        if (
                            typeof participantInitiativesAndHitPoint.startingHitPoints !==
                            'undefined'
                        ) {
                            participant.startingHitPoints =
                                participantInitiativesAndHitPoint.startingHitPoints;
                            participant.currentHitPoints =
                                participantInitiativesAndHitPoint.startingHitPoints;
                        }
                    }
                },
            );
            this._combatEncounter.addParticipant(participant);
        });

        this._combatEncounter.initialiseCombat();
    }

    isValid(): string[] {
        return [];
    }
}
