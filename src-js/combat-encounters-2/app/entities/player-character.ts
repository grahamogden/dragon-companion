import { ParticipantAbstract } from './participant-abstract';
import { ParticipantTypeEnum } from '../enums';

export class PlayerCharacter extends ParticipantAbstract {
    constructor(
        id: number,
        participantName: string,
        armourClass: number,
        maxHitPoints: number,
        dexterityModifier: number,
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
            ParticipantTypeEnum.PLAYER_CHARACTER,
        );
    }
}
