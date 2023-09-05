import { CombatTable } from './table/combat-table';
import { ParticipantAbstract } from './entities/participant-abstract';
import { CombatTurnEntity } from './entities/combat-turn';
import { CombatTurnFormHelper } from './helpers/combat-turn-form-helper';
import { ParticipantJsonHelper } from './helpers/participant-json-helper';
import { StorageAdapterInterface } from './adapters/storage-adapter-interface';
import { NotFoundException } from '../combat-encounters-2/exceptions';

export class CombatEncounter {
    readonly sessionStorageCampaign = 'campaign';
    readonly sessionStoragePlayerCharacters = 'player-characters';
    readonly sessionStorageMonsters = 'monsters';
    readonly sessionStorageParticipants = 'participants';
    readonly sessionStorageTurns = 'turns';

    participants: ParticipantAbstract[];
    combatTurns: CombatTurnEntity[];
    combatTurnHelper: CombatTurnFormHelper;
    roundCounter: number;
    turnCounter: number;
    currentParticipantKey: number;

    constructor(
        private combatTable: CombatTable,
        private participantJsonHelper: ParticipantJsonHelper,
        // private sessionStorageTurns: string,
        private temporaryStorage: StorageAdapterInterface,
    ) {
        this.participants = [];
        this.combatTurns = [];
    }

    incrementRoundCounter() {
        ++this.roundCounter;
    }

    incrementTurnCounter() {
        ++this.turnCounter;
    }

    sortParticipants() {
        this.participants.sort(function (a, b) {
            return (b.getInitiative() ?? 0) - (a.getInitiative() ?? 0);
        });
    }

    clearParticipants() {
        this.participants = [];
    }

    getParticipants(): ParticipantAbstract[] {
        return this.participants;
    }

    /**
     * @param tempId
     * @return ParticipantAbstract | null
     */
    getParticipantByTemporaryId(tempId: number) {
        for (const participant of this.getParticipants()) {
            if (participant.getTemporaryId() === tempId) {
                return participant;
            }
        }

        return null;
    }

    getParticipantArrayKeyByTemporaryId(tempId: number) {
        for (let i = 0; i < this.getParticipants().length; i++) {
            if (this.participants[i].getTemporaryId() === tempId) {
                return i;
            }
        }

        throw new NotFoundException();
    }

    selectNextParticipantKeyByCurrentTemporaryId(tempId: number) {
        let nextKey = this.getParticipantArrayKeyByTemporaryId(tempId) + 1;

        if (nextKey >= this.getParticipants().length) {
            nextKey = 0;
        }

        this.currentParticipantKey = nextKey;
    }

    addParticipant(participant: ParticipantAbstract) {
        this.participants.push(participant);
    }

    setUpCombat() {
        this.currentParticipantKey = 0;
        this.roundCounter = 0;
        this.turnCounter = 0;
        const combatTable = this.combatTable;
        const participants = this.getParticipants();

        for (const participant of participants) {
            combatTable.addRowToBottom(participant);
        }

        this.combatTable.selectTableRowForParticipantTemporaryId(
            participants[this.currentParticipantKey].getTemporaryId(),
        );

        /*****************************************
         *****************************************
         * May want to remove this at some point *
         *****************************************
         *****************************************/
        this.combatTurnHelper = new CombatTurnFormHelper(
            document.getElementById('source-participant') as HTMLSelectElement,
            document.getElementById('target-participant') as HTMLSelectElement,
            document.getElementById('combat-actions') as HTMLSelectElement,
            document.getElementById('combat-roll') as HTMLInputElement,
            document.getElementById('combat-total') as HTMLInputElement,
            document.getElementById('combat-movement') as HTMLInputElement,
            participants,
        );

        this.startNewRound();
    }

    startNewRound() {
        this.incrementRoundCounter();
        this.currentParticipantKey = 0;
        const participantKey =
            this.getParticipants()[this.currentParticipantKey].getTemporaryId();
        this.combatTable.selectTableRowForParticipantTemporaryId(
            participantKey,
        );
        this.combatTurnHelper.setUpNextTurn(participantKey);
    }

    validateTurnData(combatTurn: CombatTurnEntity) {
        const valid = true;
        if (typeof combatTurn.action === 'undefined') {
            alert('You must perform an action!');
            return false;
        }
        switch (combatTurn.action) {
            case 'ATTACK':
                if (!combatTurn.targetTempId) {
                    alert('An attack must have a target!');
                    return false;
                }
                if (!combatTurn.roll) {
                    alert('An attack must have a roll!');
                    return false;
                }
                break;
            case 'HEAL':
                if (!combatTurn.targetTempId) {
                    alert('A healing action must have a target!');
                    return false;
                }
                if (!combatTurn.total) {
                    alert('A healing action must have a total healed');
                    return false;
                }
                break;
        }
        return valid;
    }

    addTurnOfCombat() {
        const combatTurn = this.combatTurnHelper.getCombatTurnEntity(
            this.roundCounter,
            this.turnCounter,
        );
        const validated = this.validateTurnData(combatTurn);
        if (!validated) {
            return;
        }
        this.incrementTurnCounter();
        let targetParticipant: ParticipantAbstract | null = null;

        if (combatTurn.targetTempId) {
            targetParticipant = this.getParticipantByTemporaryId(
                combatTurn.targetTempId,
            );
        }

        switch (combatTurn.action) {
            case 'ATTACK':
                if (targetParticipant.getArmourClass() < combatTurn.roll) {
                    let newHitPoints =
                        targetParticipant.getCurrentHitPoints() -
                        combatTurn.total;

                    if (newHitPoints < 0) {
                        newHitPoints = 0;
                    }

                    targetParticipant.setCurrentHitPoints(newHitPoints);
                } else {
                    combatTurn.total = 0;
                }
                break;
            case 'HEAL':
                let newHitPoints =
                    targetParticipant.getCurrentHitPoints() + combatTurn.total;

                if (newHitPoints > targetParticipant.getMaxHitPoints()) {
                    newHitPoints = targetParticipant.getMaxHitPoints();
                    combatTurn.total =
                        targetParticipant.getMaxHitPoints() -
                        targetParticipant.getCurrentHitPoints();
                }

                targetParticipant.setCurrentHitPoints(newHitPoints);
                break;
            case 'PASS':
                combatTurn.total = 0;
                combatTurn.roll = 0;
                combatTurn.targetTempId = null;
                break;
            default:
                console.error(
                    'Could not determine action, please select a valid action option',
                );
                return false;
        }

        this.combatTurns.push(combatTurn);
        if (typeof targetParticipant !== 'undefined') {
            this.combatTable.updateHitPointsForParticipantTempId(
                targetParticipant,
            );
        }

        if (typeof combatTurn.sourceTempId !== 'undefined') {
            const sourceParticipantArrayKey =
                this.getParticipantArrayKeyByTemporaryId(
                    combatTurn.sourceTempId,
                );
            // If the currently selected source participant is the participant who's turn it should be, then increment the key
            if (sourceParticipantArrayKey === this.currentParticipantKey) {
                // Set the "current" participant to the next array key index
                this.selectNextParticipantKeyByCurrentTemporaryId(
                    combatTurn.sourceTempId,
                );
            }
        }

        // Set up the form for the next participant's turn (could be the same participant or the next one, depending on
        // whether this combatTurn's source was the currently selected participant or not - yes, its confusing!
        this.setUpNextTurnOfCombat(
            this.getParticipants()[this.currentParticipantKey],
        );

        this.participantJsonHelper.updateParticipantJson(
            this.getParticipants(),
        );

        this.endCombat();
    }

    setUpNextTurnOfCombat(participant: ParticipantAbstract) {
        this.combatTurnHelper.setUpNextTurn(participant.getTemporaryId());
        this.combatTable.selectTableRowForParticipantTemporaryId(
            participant.getTemporaryId(),
        );
    }

    /**
     * Doesn't actually end the combat, it just updates the JSON
     */
    endCombat() {
        const combatTurnsString = JSON.stringify(this.combatTurns);

        $('#turns').val(combatTurnsString);
        this.temporaryStorage.save(this.sessionStorageTurns, combatTurnsString);
    }

    /**
     * Purges all data related to the encounter from temporary storage
     */
    clearEncounter() {
        this.temporaryStorage.delete(this.sessionStorageCampaign);
        this.temporaryStorage.delete(this.sessionStoragePlayerCharacters);
        this.temporaryStorage.delete(this.sessionStorageMonsters);
        this.temporaryStorage.delete(this.sessionStorageParticipants);
        this.temporaryStorage.delete(this.sessionStorageTurns);
    }
}
