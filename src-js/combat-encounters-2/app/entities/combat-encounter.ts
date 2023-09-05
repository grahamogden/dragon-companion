import {
    ParticipantAbstract,
    ParticipantAbstractStateInterface,
} from './participant-abstract';
import { CombatTurnEntity } from './combat-turn';

// class CombatEncounterState {
//     constructor(
//         public campaignId: number,
//         public combatTurns: CombatTurnEntity[],
//         public participants: ParticipantAbstract[],
//     ) {}
// }

export class CombatEncounter {
    // private _campaignId: number | undefined;
    // private _participants: ParticipantAbstract[] = [];
    // // private _playerCharacters: PlayerCharacter[] = [];
    // // private _monsters: Monster[] = [];
    // private _combatTurns: CombatTurnEntity[] = [];
    // private _roundCounter = 0;
    // private _turnCounter = 0;
    // private _currentParticipantKey = 0;
    public static readonly CAMPAIGN_ID_KEY: string = 'CampaignId';
    public static readonly COMBAT_ENCOUNTER_NAME_KEY: string =
        'CombatEncounterName';
    public static readonly PARTICIPANTS_KEY: string = 'Participants';
    public static readonly COMBAT_TURNS_KEY: string = 'CombatTurns';
    public static readonly ROUND_COUNTER_KEY: string = 'RoundCounter';
    public static readonly TURN_COUNTER_KEY: string = 'TurnCounter';
    public static readonly CURRENT_PARTICIPANT_KEY_KEY: string =
        'CurrentParticipantKey';

    public constructor(
        private _campaignId: number | undefined = undefined,
        private _combatEncounterName: string | undefined = undefined,
        private _participants: ParticipantAbstract[] = [],
        // private _playerCharacters: PlayerCharacter[] = [];
        // private _monsters: Monster[] = [];
        private _combatTurns: CombatTurnEntity[] = [],
        private _roundCounter: number | undefined = undefined,
        private _turnCounter: number | undefined = undefined,
        private _currentParticipantKey: number | undefined = undefined,
    ) {}

    public getStateAsString(): string {
        const participantsArray: ParticipantAbstractStateInterface[] = [];

        for (const participant of this._participants) {
            participantsArray.push(participant.getState());
        }

        return JSON.stringify({
            [CombatEncounter.CAMPAIGN_ID_KEY]: this._campaignId,
            [CombatEncounter.COMBAT_ENCOUNTER_NAME_KEY]:
                this._combatEncounterName,
            [CombatEncounter.PARTICIPANTS_KEY]: participantsArray,
            [CombatEncounter.COMBAT_TURNS_KEY]: this._combatTurns,
            [CombatEncounter.ROUND_COUNTER_KEY]: this._roundCounter,
            [CombatEncounter.TURN_COUNTER_KEY]: this._turnCounter,
            [CombatEncounter.CURRENT_PARTICIPANT_KEY_KEY]:
                this._currentParticipantKey,
        });
    }

    // public restoreStateFromString(stateString: string): void {
    //     const state = JSON.parse(stateString) as CombatEncounterState;
    //     this._campaignId = state.campaignId;
    //     this._combatTurns = state.combatTurns;
    //     this._participants = state.participants;
    // }

    public getParticipants(): ParticipantAbstract[] {
        return this._participants;
    }

    public getParticipantByTemporaryId(
        temporaryId: number,
    ): ParticipantAbstract | null {
        for (let i = 0; i < this._participants.length; i++) {
            if (this._participants[i].temporaryId === temporaryId) {
                return this._participants[i];
            }
        }

        return null;
    }

    public getParticipantArrayKeyByTemporaryId(
        temporaryId: number,
    ): number | null {
        return (
            this.getParticipantByTemporaryId(temporaryId)?.temporaryId ?? null
        );
    }

    public selectNextParticipantKeyByCurrentTemporaryId(tempId: number): void {
        let nextKey =
            (this.getParticipantArrayKeyByTemporaryId(tempId) ?? 0) + 1;

        if (nextKey >= this.getParticipants().length) {
            nextKey = 0;
        }

        this._currentParticipantKey = nextKey;
    }

    get participants(): ParticipantAbstract[] {
        return this._participants;
    }

    set participants(value: ParticipantAbstract[]) {
        this._participants = value;
    }

    public addParticipant(participant: ParticipantAbstract): void {
        this._participants.push(participant);
    }

    public addCombatTurn(combatTurn: CombatTurnEntity): void {
        this._combatTurns.push(combatTurn);
    }

    get combatTurns(): CombatTurnEntity[] {
        return this._combatTurns;
    }

    set combatTurns(value: CombatTurnEntity[]) {
        this._combatTurns = value;
    }

    get roundCounter(): number | undefined {
        return this._roundCounter;
    }

    set roundCounter(value: number) {
        this._roundCounter = value;
    }

    get turnCounter(): number | undefined {
        return this._turnCounter;
    }

    set turnCounter(value: number) {
        this._turnCounter = value;
    }

    get currentParticipantKey(): number | undefined {
        return this._currentParticipantKey;
    }

    set currentParticipantKey(value: number) {
        this._currentParticipantKey = value;
    }

    get campaignId(): number | undefined {
        return this._campaignId;
    }

    set campaignId(value: number | undefined) {
        this._campaignId = value;
    }

    get combatEncounterName(): string | undefined {
        return this._combatEncounterName;
    }

    set combatEncounterName(value: string | undefined) {
        this._combatEncounterName = value;
    }
}
