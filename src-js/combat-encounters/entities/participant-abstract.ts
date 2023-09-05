import { ParticipantTypeEnum } from '../enums/enums/participant-type-enum';

export class ParticipantAbstract {
    // id: number;
    private temporaryId: number;
    // participantName: string;
    // armourClass: number;
    // maxHitPoints: number;
    // dexterityModifier: number;
    // startingHitPoints: number;
    // currentHitPoints: number;
    // initiative?: number;
    // participantType: ParticipantTypes;

    constructor(
        protected id: number,
        protected participantName: string,
        protected armourClass: number,
        protected maxHitPoints: number,
        protected dexterityModifier: number,
        protected startingHitPoints: number | undefined = undefined,
        protected currentHitPoints: number | undefined = undefined,
        protected initiative: number | undefined = undefined,
        protected participantType: ParticipantTypeEnum,
    ) {
        this.id = id;
        this.participantName = participantName;
        this.armourClass = armourClass;
        this.maxHitPoints = maxHitPoints;
        this.dexterityModifier = dexterityModifier;
        this.startingHitPoints = startingHitPoints ?? this.maxHitPoints;
        this.currentHitPoints = currentHitPoints ?? this.startingHitPoints;
        this.initiative = initiative;
        this.participantType = participantType;
        this.createTempId();
    }

    // getId() {
    //     return this.id;
    // }

    getName() {
        return this.participantName;
    }

    getArmourClass() {
        return this.armourClass;
    }

    getMaxHitPoints() {
        return this.maxHitPoints;
    }

    getDexterityModifier() {
        return this.dexterityModifier;
    }

    getTemporaryId() {
        return this.temporaryId;
    }

    getStartingHitPoints() {
        return this.startingHitPoints;
    }

    setStartingHitPoints(startingHitPoints: number) {
        this.startingHitPoints = startingHitPoints;
    }

    getCurrentHitPoints() {
        return this.currentHitPoints;
    }

    setCurrentHitPoints(newHitPoints: number) {
        this.currentHitPoints = newHitPoints;
    }

    getInitiative() {
        return this.initiative;
    }

    setInitiative(initiative: number) {
        this.initiative = initiative;
    }

    /*
     * Create a number that is 10 characters long and assign it to tempId
     */
    private createTempId() {
        let milliseconds = Date.now().toString();
        milliseconds = milliseconds.substr(-4);

        const randomNumber = Math.floor(1000 + Math.random() * 9999).toString();

        this.temporaryId = parseInt(randomNumber + milliseconds);
    }
}
