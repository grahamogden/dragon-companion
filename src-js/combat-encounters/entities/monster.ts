import { ParticipantAbstract } from './participant-abstract';
import { ParticipantTypeEnum } from '../enums/enums/participant-type-enum';

export class Monster extends ParticipantAbstract {
    private monsterInstanceTypeId: number;

    constructor(
        id: number,
        participantName: string,
        armourClass: number,
        maxHitPoints: number,
        dexterityModifier: number,
        monsterInstanceTypeId,
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
            ParticipantTypeEnum.MONSTER,
        );
        this.monsterInstanceTypeId = monsterInstanceTypeId;
    }
}
