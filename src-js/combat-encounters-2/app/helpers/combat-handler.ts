import {
    CombatTurnEntity,
    Monster,
    ParticipantAbstract,
    ParticipantFromJson,
    PlayerCharacter,
} from '../entities';
import { CombatTableHelper } from '../table';
import { CombatTurnFormHelper } from './combat-turn-form-helper';
import { MonsterInstanceTypeEnum } from '../enums';

/**
 * Handles everything to do with the actual combat itself - what round we're in,
 * what monsters are there, who has attacked who, etc.
 */
export class CombatHandler {
    private _participants: ParticipantAbstract[] = [];
    private _playerCharacters: PlayerCharacter[] = [];
    private _monsters: Monster[] = [];
    private combatTurns: CombatTurnEntity[];
    private roundCounter = 0;
    private turnCounter = 0;
    private currentParticipantKey = 0;

    constructor(
        /*private initiativeTableHelper: InitiativeTableHelper,*/ private combatTableHelper: CombatTableHelper,
        private combatTurnFormHelper: CombatTurnFormHelper,
    ) {
        this.combatTurns = [];
    }

    public getHistory() {
        return this.combatTurns;
    }

    public addTurnOfCombat() {
        const combatTurn = this.combatTurnFormHelper.getCombatTurnEntity(
            this.roundCounter,
            this.turnCounter,
        );
        const validated = this.validateTurnData(combatTurn);
        if (!validated) {
            return;
        }
        this.incrementTurnCounter();
        let targetParticipant: ParticipantAbstract | null = null;

        if (combatTurn.targetTemporaryId) {
            targetParticipant = this.getParticipantByTemporaryId(
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
                return false;
        }

        this.combatTurns.push(combatTurn);
        if (null !== targetParticipant) {
            this.combatTableHelper.updateHitPointsForParticipantTempId(
                targetParticipant,
            );
        }

        if (typeof combatTurn.sourceTemporaryId !== 'undefined') {
            const sourceParticipantArrayKey =
                this.getParticipantArrayKeyByTemporaryId(
                    combatTurn.sourceTemporaryId,
                );
            // If the currently selected source participant is the participant who's turn it should be, then increment the key
            if (sourceParticipantArrayKey === this.currentParticipantKey) {
                // Set the "current" participant to the next array key index
                this.selectNextParticipantKeyByCurrentTemporaryId(
                    combatTurn.sourceTemporaryId,
                );
            }
        }

        // Set up the form for the next participant's turn (could be the same participant or the next one, depending on
        // whether this combatTurn's source was the currently selected participant or not - yes, its confusing!
        this.setUpNextTurnOfCombat(
            this.getParticipants()[this.currentParticipantKey],
        );

        // this.participantJsonHelper.updateParticipantJson(
        //     this.getParticipants(),
        // );

        // this.endCombat();
    }

    setUpNextTurnOfCombat(participant: ParticipantAbstract) {
        this.combatTurnFormHelper.setUpNextTurn(participant.temporaryId);
        this.combatTableHelper.selectTableRowForParticipantTemporaryId(
            participant.temporaryId,
        );
    }

    public incrementRoundCounter() {
        ++this.roundCounter;
    }

    public incrementTurnCounter() {
        ++this.turnCounter;
    }

    public sortParticipants() {
        this._participants.sort(function (a, b) {
            return (b.initiative ?? 0) - (a.initiative ?? 0);
        });
    }

    public clearParticipants() {
        this._playerCharacters = [];
        this._monsters = [];
        this._participants = [];
    }

    public updatePlayerCharacters(playerCharacters: ParticipantFromJson[]) {
        const playerCharacterIds: number[] = [];
        this._playerCharacters.forEach((playerCharacter) => {
            playerCharacterIds.push(playerCharacter.id);
        });

        playerCharacters.forEach((playerCharacter) => {
            // add player character if they do not already exist in the list of participants
            if (playerCharacterIds.indexOf(playerCharacter.data.id) < 0) {
                this.addPlayerCharacter(
                    new PlayerCharacter(
                        playerCharacter.data.id,
                        playerCharacter.data.name,
                        playerCharacter.data.armour_class,
                        playerCharacter.data.max_hit_points,
                        playerCharacter.data.dexterity_modifier,
                    ),
                );
            }
        });

        return this._playerCharacters;
    }

    public addPlayerCharacter(playerCharacter: PlayerCharacter) {
        this._playerCharacters.push(playerCharacter);
    }

    public getPlayerCharacters(): PlayerCharacter[] {
        return this._playerCharacters;
    }

    public updateMonsters(monsters: ParticipantFromJson[]) {
        const monsterIds: number[] = [];
        this._monsters.forEach((monster) => {
            monsterIds.push(monster.id);
        });

        monsters.forEach((monster) => {
            // add player character if they do not already exist in the list of participants
            if (monsterIds.indexOf(monster.data.id) < 0) {
                this.addMonster(
                    new Monster(
                        monster.data.id,
                        monster.data.name,
                        monster.data.armour_class,
                        monster.data.max_hit_points,
                        monster.data.dexterity_modifier,
                        MonsterInstanceTypeEnum.INDIVIDUAL,
                    ),
                );
            }
        });

        return this._monsters;
    }

    public addMonster(monster: Monster) {
        this._monsters.push(monster);
    }

    public getMonsters(): Monster[] {
        return this._monsters;
    }

    public getParticipants(): Array<PlayerCharacter | Monster> {
        return this.getPlayerCharacters().concat(this.getMonsters());
    }

    /**
     * @param temporaryId
     */
    private getParticipantByTemporaryId(
        temporaryId: number,
    ): ParticipantAbstract | null {
        for (let i = 0; i < this.getParticipants().length; i++) {
            if (this._participants[i].temporaryId === temporaryId) {
                return this._participants[i];
            }
        }

        return null;
    }

    private getParticipantArrayKeyByTemporaryId(
        temporaryId: number,
    ): number | null {
        return (
            this.getParticipantByTemporaryId(temporaryId)?.temporaryId ?? null
        );
    }

    private selectNextParticipantKeyByCurrentTemporaryId(tempId: number) {
        let nextKey =
            (this.getParticipantArrayKeyByTemporaryId(tempId) ?? 0) + 1;

        if (nextKey >= this.getParticipants().length) {
            nextKey = 0;
        }

        this.currentParticipantKey = nextKey;
    }

    // public setUpCombat() {
    //     this.currentParticipantKey = 0;
    //     this.roundCounter = 0;
    //     this.turnCounter = 0;
    //     const combatTable = this.combatTableHelper;
    //     const participants = this.getParticipants();
    //
    //     for (let i = 0; i < participants.length; i++) {
    //         combatTable.addRowToBottom(i, participants[i]);
    //     }
    //
    //     this.combatTableHelper.selectTableRowForParticipantTemporaryId(
    //         participants[this.currentParticipantKey].temporaryId,
    //     );
    //
    //     /*****************************************
    //      *****************************************
    //      * May want to remove this at some point *
    //      *****************************************
    //      *****************************************/
    //     this.combatTurnFormHelper = new CombatTurnFormHelper(
    //         document.getElementById('source-participant') as HTMLSelectElement,
    //         document.getElementById('target-participant') as HTMLSelectElement,
    //         document.getElementById('combat-actions') as HTMLSelectElement,
    //         document.getElementById('combat-roll') as HTMLInputElement,
    //         document.getElementById('combat-total') as HTMLInputElement,
    //         document.getElementById('combat-movement') as HTMLInputElement,
    //         participants,
    //     );
    //
    //     this.startNewRound();
    // }

    public startNewRound() {
        this.incrementRoundCounter();
        this.currentParticipantKey = 0;
        const participantKey =
            this.getParticipants()[this.currentParticipantKey].temporaryId;
        this.combatTableHelper.selectTableRowForParticipantTemporaryId(
            participantKey,
        );
        this.combatTurnFormHelper.setUpNextTurn(participantKey);
    }

    public validateTurnData(combatTurn: CombatTurnEntity) {
        const valid = true;
        if (typeof combatTurn.action === 'undefined') {
            alert('You must perform an action!');
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
                if (!combatTurn.total) {
                    alert('A healing action must have a total healed');
                    return false;
                }
                break;
        }
        return valid;
    }
}
