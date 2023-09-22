import { FormPage } from '../form-helper/form-page';
import {
    Monster,
    MonsterParticipantFromJson,
    ParticipantFromJson,
    PlayerCharacter,
} from '../entities';
import { CombatEncounterHandler } from '../combat-encounter-handler';
import { NotFoundException } from '../exceptions';
import { FormPageInterface } from '../form-helper';

export class ParticipantsPage extends FormPage implements FormPageInterface {
    private readonly _playerCharacterInput: HTMLInputElement;
    private readonly _monsterInput: HTMLInputElement;
    public static readonly PAGE_ID = 'combat-encounters-participants';

    constructor(private readonly _combatEncounter: CombatEncounterHandler) {
        super(ParticipantsPage.PAGE_ID);
        this._playerCharacterInput = this.initPlayerCharacterInput();
        this._monsterInput = this.initMonsterInput();
    }

    buildForm(): void {
        console.debug('Building participants page');
        // this.
    }

    private initPlayerCharacterInput() {
        const playerCharacterInput = this._fieldset.querySelector(
            '#player-characters',
        ) as HTMLInputElement | null;
        if (playerCharacterInput === null) {
            throw new NotFoundException(' not found');
        }

        playerCharacterInput.addEventListener('change', function (event) {
            event.preventDefault();
        });

        return playerCharacterInput;
    }

    private initMonsterInput() {
        const monsterInput = this._fieldset.querySelector(
            '#monsters',
        ) as HTMLInputElement | null;
        if (monsterInput === null) {
            throw new NotFoundException(' not found');
        }

        monsterInput.addEventListener('change', function (event) {
            event.preventDefault();
        });

        return monsterInput;
    }

    action(): void {
        this._combatEncounter.clearParticipants();
        const playerCharacters = this.getPlayerCharacterInputValues();
        for (const playerCharacterJson of playerCharacters) {
            const playerCharacter = new PlayerCharacter(
                playerCharacterJson.data.id,
                playerCharacterJson.data.temporary_id,
                playerCharacterJson.data.name,
                playerCharacterJson.data.armour_class,
                playerCharacterJson.data.max_hit_points,
                playerCharacterJson.data.dexterity_modifier,
                playerCharacterJson.data.max_hit_points,
                playerCharacterJson.data.max_hit_points,
                0,
            );
            this._combatEncounter.addParticipant(playerCharacter);
        }
        const monsters = this.getMonsterInputValues();
        for (const monsterJson of monsters) {
            const monster = new Monster(
                monsterJson.data.id,
                monsterJson.data.temporary_id,
                monsterJson.data.name,
                monsterJson.data.armour_class,
                monsterJson.data.max_hit_points,
                monsterJson.data.dexterity_modifier,
                // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
                monsterJson.data.monster_instance_type_id!,
                monsterJson.data.max_hit_points,
                monsterJson.data.max_hit_points,
                0,
            );
            this._combatEncounter.addParticipant(monster);
        }
    }

    private getMonsterInputValues(): MonsterParticipantFromJson[] {
        const monsterValue = this._monsterInput.value;

        return JSON.parse(
            '' !== monsterValue ? monsterValue : '[]',
        ) as MonsterParticipantFromJson[];
    }

    private getPlayerCharacterInputValues() {
        const playerCharacterValue = this._playerCharacterInput.value;

        return JSON.parse(
            '' !== playerCharacterValue ? playerCharacterValue : '[]',
        ) as ParticipantFromJson[];
    }

    isValid(): string[] {
        const participants = this.getPlayerCharacterInputValues().concat(
            this.getMonsterInputValues(),
        );

        if (participants.length === 0) {
            return ['Please select some participants'];
        }

        return [];
    }
}
