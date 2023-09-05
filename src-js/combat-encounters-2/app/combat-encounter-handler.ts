import { CombatTurnFormHelper } from './helpers';
import { StorageAdapterInterface } from './adapters';
import {
    CombatTurnEntity,
    Monster,
    MonsterStateInterface,
    ParticipantAbstract,
    ParticipantAbstractStateInterface,
    PlayerCharacter,
    CombatEncounter,
} from './entities';
import { CombatTableHelper } from './table';
import { NotFoundException } from './exceptions';

export class CombatEncounterHandler {
    readonly sessionStorageCampaign = 'campaign';
    readonly sessionStoragePlayerCharacters = 'player-characters';
    readonly sessionStorageMonsters = 'monsters';
    readonly sessionStorageParticipants = 'participants';
    readonly sessionStorageTurns = 'turns';

    private readonly COMBAT_ACTIONS = ['ATTACK', 'HEAL', 'PASS'];
    public readonly STORAGE_KEY = 'encounter';

    // private _participants: ParticipantAbstract[] = [];
    // // private _playerCharacters: PlayerCharacter[] = [];
    // // private _monsters: Monster[] = [];
    // private _combatTurns: CombatTurnEntity[] = [];
    // private _roundCounter = 0;
    // private _turnCounter = 0;
    // private _currentParticipantKey = 0;
    // private _campaignId: number | undefined;
    private _combatEncounter: CombatEncounter;

    constructor(
        // public combatHandler: CombatHandler,
        private _combatTurnFormHelper: CombatTurnFormHelper,
        // private initiativeTable: InitiativeTableHelper,
        // private formHelper: FormHelper,
        // private sessionStorageTurns: string,
        private _temporaryStorage: StorageAdapterInterface,
    ) {
        this._combatEncounter = new CombatEncounter();
    }

    /**
     * Doesn't actually end the combat, it just updates the JSON
     */
    endCombat() {
        const combatTurnsString = JSON.stringify(
            this._combatEncounter.combatTurns,
        );

        const turnsInput = document.getElementById('turns') as HTMLInputElement;
        turnsInput.value = combatTurnsString;
        if (this._temporaryStorage) {
            this._temporaryStorage.save(
                this.sessionStorageTurns,
                combatTurnsString,
            );
        }
    }

    /**
     * Purges all data related to the encounter from temporary storage
     */
    public clearEncounter() {
        if (!this._temporaryStorage) {
            return;
        }

        this._temporaryStorage.delete(this.sessionStorageCampaign);
        this._temporaryStorage.delete(this.sessionStoragePlayerCharacters);
        this._temporaryStorage.delete(this.sessionStorageMonsters);
        this._temporaryStorage.delete(this.sessionStorageParticipants);
        this._temporaryStorage.delete(this.sessionStorageTurns);
    }

    public updateCampaign(campaignId: number) {
        // this._campaignId = campaignId;
        this._combatEncounter.campaignId = campaignId;
        this._temporaryStorage.save(
            this.STORAGE_KEY,
            this._combatEncounter.getStateAsString(),
        );
        // this.temporaryStorage.save(this.sessionStorageCampaign, _campaignId);
    }

    // public setParticipantStartingValuesOnCombatEncounter() {
    //     $.each(
    //         combatEncounter.getParticipants(),
    //         function (index: number, participant: ParticipantAbstract) {
    //             const hitPoints = parseInt(
    //                 (
    //                     document.getElementById(
    //                         'participant-starting-hit-points-' +
    //                             participant.temporaryId,
    //                     ) as HTMLInputElement
    //                 ).value,
    //             );
    //             participant.startingHitPoints = hitPoints;
    //             participant.currentHitPoints = hitPoints;
    //
    //             participant.initiative = parseInt(
    //                 (
    //                     document.getElementById(
    //                         'participant-initiative-' + participant.temporaryId,
    //                     ) as HTMLInputElement
    //                 ).value,
    //             );
    //         },
    //     );
    //
    //     combatEncounter.sortParticipants();
    // }

    // public setUpCombatTable(combatTableHelper: CombatTableHelper) {
    //     combatTableHelper.updateParticipantSelects(this._participants);
    // }

    // public sortParticipants() {
    //     this._participants.sort(function (a, b) {
    //         return (b.initiative ?? 0) - (a.initiative ?? 0);
    //     });
    // }

    public clearParticipants() {
        // this._playerCharacters = [];
        // this._monsters = [];
        // this._participants = [];
        this._combatEncounter.participants = [];
        this._temporaryStorage.save(
            this.STORAGE_KEY,
            this._combatEncounter.getStateAsString(),
        );
    }

    // public updatePlayerCharacters(playerCharacters: ParticipantFromJson[]) {
    //     const playerCharacterIds: number[] = [];
    //     this._playerCharacters.forEach((playerCharacter) => {
    //         playerCharacterIds.push(playerCharacter.id);
    //     });
    //
    //     playerCharacters.forEach((playerCharacter) => {
    //         // add player character if they do not already exist in the list of participants
    //         if (playerCharacterIds.indexOf(playerCharacter.data.id) < 0) {
    //             this.addPlayerCharacter(
    //                 new PlayerCharacter(
    //                     playerCharacter.data.id,
    //                     playerCharacter.data.name,
    //                     playerCharacter.data.armour_class,
    //                     playerCharacter.data.max_hit_points,
    //                     playerCharacter.data.dexterity_modifier,
    //                 ),
    //             );
    //         }
    //     });
    //
    //     // this.temporaryStorage.save(
    //     //     this.sessionStoragePlayerCharacters,
    //     //     this.combatHandler.updatePlayerCharacters(playerCharacters),
    //     // );
    //
    //     return this._playerCharacters;
    // }

    // public addPlayerCharacter(playerCharacter: PlayerCharacter) {
    //     this._playerCharacters.push(playerCharacter);
    // }

    public addParticipant(participant: ParticipantAbstract) {
        // this._participants.push(participant);
        this._combatEncounter.addParticipant(participant);
        this._temporaryStorage.save(
            this.STORAGE_KEY,
            this._combatEncounter.getStateAsString(),
        );
    }

    // public getPlayerCharacters(): PlayerCharacter[] {
    //     return this._playerCharacters;
    // }

    // public updateMonsters(monsters: ParticipantFromJson[]) {
    //     const monsterIds: number[] = [];
    //     this._monsters.forEach((monster) => {
    //         monsterIds.push(monster.id);
    //     });
    //
    //     monsters.forEach((monster) => {
    //         // add player character if they do not already exist in the list of participants
    //         if (monsterIds.indexOf(monster.data.id) < 0) {
    //             this.addMonster(
    //                 new Monster(
    //                     monster.data.id,
    //                     monster.data.name,
    //                     monster.data.armour_class,
    //                     monster.data.max_hit_points,
    //                     monster.data.dexterity_modifier,
    //                     MonsterInstanceTypeEnum.INDIVIDUAL,
    //                 ),
    //             );
    //         }
    //     });
    //
    //     // this.temporaryStorage.save(
    //     //     this.sessionStorageMonsters,
    //     //     this.combatHandler.updateMonsters(monsters),
    //     // );
    //
    //     return this._monsters;
    // }

    // public addMonster(monster: Monster) {
    //     this._monsters.push(monster);
    // }

    // public getMonsters(): Monster[] {
    //     return this._monsters;
    // }

    public getParticipants(): ParticipantAbstract[] {
        return this._combatEncounter.getParticipants();
    }

    // /**
    //  * @param temporaryId
    //  */
    // private getParticipantByTemporaryId(
    //     temporaryId: number,
    // ): ParticipantAbstract | null {
    //     for (
    //         let i = 0;
    //         i < this._combatEncounter.getParticipants().length;
    //         i++
    //     ) {
    //         if (this._participants[i].temporaryId === temporaryId) {
    //             return this._participants[i];
    //         }
    //     }
    //
    //     return null;
    // }
    //
    // private getParticipantArrayKeyByTemporaryId(
    //     temporaryId: number,
    // ): number | null {
    //     return (
    //         this.getParticipantByTemporaryId(temporaryId)?.temporaryId ?? null
    //     );
    // }
    //
    // private selectNextParticipantKeyByCurrentTemporaryId(tempId: number) {
    //     let nextKey =
    //         (this.getParticipantArrayKeyByTemporaryId(tempId) ?? 0) + 1;
    //
    //     if (nextKey >= this.getParticipants().length) {
    //         nextKey = 0;
    //     }
    //
    //     this._currentParticipantKey = nextKey;
    // }

    private completeTurnAction(
        combatTableHelper: CombatTableHelper,
    ): void | CombatTurnEntity {
        if (typeof this._combatEncounter.roundCounter === 'undefined') {
            throw new NotFoundException(
                'Round counter could not be found to complete turn action',
            );
        }

        if (typeof this._combatEncounter.turnCounter === 'undefined') {
            throw new NotFoundException(
                'Turn counter could not be found to complete turn action',
            );
        }

        const combatTurn = this._combatTurnFormHelper.getCombatTurnEntity(
            this._combatEncounter.roundCounter,
            this._combatEncounter.turnCounter,
        );

        const validated = this.validateTurnData(combatTurn);
        if (!validated) {
            return;
        }

        let targetParticipant: ParticipantAbstract | null = null;

        if (combatTurn.targetTemporaryId) {
            targetParticipant =
                this._combatEncounter.getParticipantByTemporaryId(
                    combatTurn.targetTemporaryId,
                );
        }

        switch (combatTurn.action) {
            case 'ATTACK':
                if (!targetParticipant) {
                    break;
                }

                if (targetParticipant.armourClass < combatTurn.roll) {
                    let newHitPoints =
                        targetParticipant.currentHitPoints - combatTurn.total;

                    if (newHitPoints < 0) {
                        newHitPoints = 0;
                    }

                    targetParticipant.currentHitPoints = newHitPoints;
                } else {
                    combatTurn.total = 0;
                }
                break;
            case 'HEAL':
                if (!targetParticipant) {
                    break;
                }

                let newHitPoints =
                    targetParticipant.currentHitPoints + combatTurn.total;

                // May not be needed as you can get temporary hit points
                if (newHitPoints > targetParticipant.maxHitPoints) {
                    newHitPoints = targetParticipant.maxHitPoints;
                    combatTurn.total =
                        targetParticipant.maxHitPoints -
                        targetParticipant.currentHitPoints;
                }

                targetParticipant.currentHitPoints = newHitPoints;
                break;
            case 'PASS':
                combatTurn.total = 0;
                combatTurn.roll = 0;
                combatTurn.targetTemporaryId = null;
                break;
            default:
                console.error(
                    'Could not determine action, please select a valid action option',
                );
                return;
        }

        this._combatEncounter.addCombatTurn(combatTurn);
        this._temporaryStorage.save(
            this.STORAGE_KEY,
            this._combatEncounter.getStateAsString(),
        );
        if (null !== targetParticipant) {
            combatTableHelper.updateHitPointsForParticipantTempId(
                targetParticipant,
            );
        }

        return combatTurn;
    }

    public addAnotherTarget(combatTableHelper: CombatTableHelper): void {
        if (
            typeof this._combatEncounter.currentParticipantKey === 'undefined'
        ) {
            throw new NotFoundException(
                'Current participant key could not be found to add another target',
            );
        }
        this.completeTurnAction(combatTableHelper);
        this.setUpNextTurnOfCombat(
            this.getParticipants()[this._combatEncounter.currentParticipantKey],
            combatTableHelper,
        );
    }

    public addTurnOfCombat(combatTableHelper: CombatTableHelper): void {
        const combatTurn = this.completeTurnAction(combatTableHelper);

        if (!combatTurn) {
            return;
        }

        if (typeof combatTurn.sourceTemporaryId !== 'undefined') {
            const sourceParticipantArrayKey =
                this._combatEncounter.getParticipantArrayKeyByTemporaryId(
                    combatTurn.sourceTemporaryId,
                );
            // If the currently selected source participant is the participant who's turn it should be, then increment the key
            if (
                sourceParticipantArrayKey ===
                this._combatEncounter.currentParticipantKey
            ) {
                // Set the "current" participant to the next array key index
                this._combatEncounter.selectNextParticipantKeyByCurrentTemporaryId(
                    combatTurn.sourceTemporaryId,
                );
            }
        }

        this.incrementTurnCounter();
        // Set up the form for the next participant's turn (could be the same participant or the next one, depending on
        // whether this combatTurn's source was the currently selected participant or not - yes, its confusing!
        this.setUpNextTurnOfCombat(
            this.getParticipants()[
                this._combatEncounter.currentParticipantKey ?? 0
            ],
            combatTableHelper,
        );

        // this.participantJsonHelper.updateParticipantJson(
        //     this.getParticipants(),
        // );

        // this.endCombat();
    }

    private setUpNextTurnOfCombat(
        participant: ParticipantAbstract,
        combatTableHelper: CombatTableHelper,
    ) {
        this._combatTurnFormHelper.setUpNextTurn(participant.temporaryId);
        combatTableHelper.selectTableRowForParticipantTemporaryId(
            participant.temporaryId,
        );
    }

    public initialiseCombat() {
        this._combatEncounter.roundCounter = 0;
        this._combatEncounter.turnCounter = 0;
        this._combatEncounter.combatTurns = [];
        this._combatEncounter.currentParticipantKey = 0;
    }

    public startNewRound(combatTableHelper: CombatTableHelper) {
        this.incrementRoundCounter();
        this._combatEncounter.currentParticipantKey = 0;
        const participantKey =
            this.getParticipants()[this._combatEncounter.currentParticipantKey]
                .temporaryId;
        combatTableHelper.selectTableRowForParticipantTemporaryId(
            participantKey,
        );
        this._combatTurnFormHelper.setUpNextTurn(participantKey);
        this._temporaryStorage.save(
            this.STORAGE_KEY,
            this._combatEncounter.getStateAsString(),
        );
    }

    public incrementRoundCounter() {
        let currentRoundCounter = this._combatEncounter.roundCounter ?? 0;
        this._combatEncounter.roundCounter = ++currentRoundCounter;
    }

    public incrementTurnCounter() {
        let currentTurnCounter = this._combatEncounter.turnCounter ?? 0;
        this._combatEncounter.turnCounter = ++currentTurnCounter;
    }

    public restoreFromJsonString(stateString: string) {
        const state = JSON.parse(stateString);
        this.restoreState(
            state[CombatEncounter.CAMPAIGN_ID_KEY] ?? undefined,
            state[CombatEncounter.COMBAT_ENCOUNTER_NAME_KEY] ?? undefined,
            state[CombatEncounter.PARTICIPANTS_KEY] ?? undefined,
            state[CombatEncounter.COMBAT_TURNS_KEY] ?? undefined,
            state[CombatEncounter.ROUND_COUNTER_KEY] ?? undefined,
            state[CombatEncounter.TURN_COUNTER_KEY] ?? undefined,
            state[CombatEncounter.CURRENT_PARTICIPANT_KEY_KEY] ?? undefined,
        );

        return {
            [CombatEncounter.CAMPAIGN_ID_KEY]:
                typeof this._combatEncounter.campaignId !== 'undefined',
            [CombatEncounter.COMBAT_ENCOUNTER_NAME_KEY]:
                typeof this._combatEncounter.combatEncounterName !==
                'undefined',
            [CombatEncounter.PARTICIPANTS_KEY]:
                this._combatEncounter.getParticipants().length > 0,
            [CombatEncounter.COMBAT_TURNS_KEY]:
                this._combatEncounter.combatTurns.length > 0,
            [CombatEncounter.ROUND_COUNTER_KEY]:
                typeof this._combatEncounter.roundCounter !== 'undefined',
            [CombatEncounter.TURN_COUNTER_KEY]:
                typeof this._combatEncounter.turnCounter !== 'undefined',
            [CombatEncounter.CURRENT_PARTICIPANT_KEY_KEY]:
                typeof this._combatEncounter.currentParticipantKey !==
                'undefined',
        };
    }

    private restoreState(
        campaignId?: number,
        combatEncounterName?: string,
        participants?: (
            | MonsterStateInterface
            | ParticipantAbstractStateInterface
        )[],
        combatTurns?: CombatTurnEntity[],
        roundCounter?: number,
        turnCounter?: number,
        currentParticipantKey?: number,
    ) {
        this._combatEncounter = new CombatEncounter(
            campaignId,
            combatEncounterName,
            [],
            combatTurns,
            roundCounter,
            turnCounter,
            currentParticipantKey,
        );

        console.debug(this._combatEncounter);
        console.debug(participants);
        for (const participantAbstract of participants ?? []) {
            let participant: Monster | PlayerCharacter;
            if (
                // typeof participantAbstract?.monsterInstanceTypeId !== undefined
                // participantAbstract.constructor === Monster

                // participantAbstract.ParticipantType ===
                // ParticipantTypeEnum.MONSTER

                `MonsterInstanceType` in participantAbstract
            ) {
                participant = new Monster(
                    participantAbstract.Id,
                    participantAbstract.ParticipantName,
                    participantAbstract.ArmourClass,
                    participantAbstract.MaxHitPoints,
                    participantAbstract.DexterityModifier,
                    participantAbstract.MonsterInstanceType,
                    participantAbstract.StartingHitPoints,
                    participantAbstract.CurrentHitPoints,
                    participantAbstract.Initiative,
                );
            } else {
                participant = new PlayerCharacter(
                    participantAbstract.Id,
                    participantAbstract.ParticipantName,
                    participantAbstract.ArmourClass,
                    participantAbstract.MaxHitPoints,
                    participantAbstract.DexterityModifier,
                    participantAbstract.StartingHitPoints,
                    participantAbstract.CurrentHitPoints,
                    participantAbstract.Initiative,
                );
            }
            this._combatEncounter.addParticipant(participant);
        }
        console.debug(this._combatEncounter);
    }

    private validateTurnData(combatTurn: CombatTurnEntity) {
        const valid = true;
        if (
            typeof combatTurn.action === 'undefined' ||
            !this.COMBAT_ACTIONS.includes(combatTurn.action)
        ) {
            alert('You must perform a valid action!');
            return false;
        }
        switch (combatTurn.action) {
            case 'ATTACK':
                if (!combatTurn.targetTemporaryId) {
                    alert('An attack must have a target!');
                    return false;
                }
                if (!combatTurn.roll) {
                    alert('An attack must have a roll!');
                    return false;
                }
                break;
            case 'HEAL':
                if (!combatTurn.targetTemporaryId) {
                    alert('A healing action must have a target!');
                    return false;
                }
                if (!combatTurn.total && combatTurn.total !== 0) {
                    alert('A healing action must have a total healed!');
                    return false;
                }
                break;
        }

        return valid;
    }
}
