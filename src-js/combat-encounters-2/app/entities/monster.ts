import {
    ParticipantAbstract,
    ParticipantAbstractStateInterface,
} from './participant-abstract';
import { MonsterInstanceTypeEnum, ParticipantTypeEnum } from '../enums';

export class Monster extends ParticipantAbstract {
    // private monsterInstanceTypeId: number;
    // public static readonly MONSTER_MONSTER_INSTANCE_TYPE_KEY =
    //     'MonsterInstanceType';

    constructor(
        id: number,
        temporaryId: number,
        participantName: string,
        armourClass: number,
        maxHitPoints: number,
        dexterityModifier: number,
        private _monsterInstanceTypeId: number,
        startingHitPoints: number | undefined = undefined,
        currentHitPoints: number | undefined = undefined,
        initiative: number | undefined = undefined,
    ) {
        super(
            id,
            participantName,
            armourClass,
            maxHitPoints,
            dexterityModifier,
            startingHitPoints,
            currentHitPoints,
            initiative,
            temporaryId,
            ParticipantTypeEnum.MONSTER,
        );
        this._monsterInstanceTypeId = _monsterInstanceTypeId;
    }

    public get monsterInstanceTypeId(): MonsterInstanceTypeEnum {
        return this._monsterInstanceTypeId;
    }

    public set monsterInstanceTypeId(typeId: MonsterInstanceTypeEnum) {
        this._monsterInstanceTypeId = typeId;
    }

    public getState(): MonsterStateInterface {
        return {
            ...super.getState(),
            MonsterInstanceType: this.monsterInstanceTypeId,
        };
    }
}

export interface MonsterStateInterface
    extends ParticipantAbstractStateInterface {
    MonsterInstanceType: MonsterInstanceTypeEnum;
}
