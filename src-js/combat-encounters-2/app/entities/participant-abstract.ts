import { ParticipantTypeEnum } from '../enums';

export class ParticipantAbstract {
    private readonly _id: number;
    private readonly _participantName: string;
    private readonly _armourClass: number;
    private readonly _maxHitPoints: number;
    private readonly _dexterityModifier: number;
    private _startingHitPoints: number;
    private _currentHitPoints: number;
    private _initiative: number | undefined;
    private readonly _participantType: ParticipantTypeEnum;
    /**
     * _temporaryId - This is required because some monsters would have the
     * same ID if they were to use their actual ID instead. In other words,
     * individual monsters would be fine but species monsters would cause issues
     */
    private readonly _temporaryId: number;

    // public static readonly PARTICIPANTS_ID_KEY = 'Id';
    // public static readonly PARTICIPANTS_PARTICIPANT_NAME_KEY =
    //     'ParticipantName';
    // public static readonly PARTICIPANTS_ARMOUR_CLASS_KEY = 'ArmourClass';
    // public static readonly PARTICIPANTS_MAX_HIT_POINTS_KEY = 'MaxHitPoints';
    // public static readonly PARTICIPANTS_DEXTERITY_MODIFIER_KEY =
    //     'DexterityModifier';
    // public static readonly PARTICIPANTS_STARTING_HIT_POINTS_KEY =
    //     'StartingHitPoints';
    // public static readonly PARTICIPANTS_CURRENT_HIT_POINTS_KEY =
    //     'CurrentHitPoints';
    // public static readonly PARTICIPANTS_INITIATIVE_KEY = 'Initiative';
    // public static readonly PARTICIPANTS_PARTICIPANT_TYPE_KEY =
    //     'ParticipantType';

    constructor(
        id: number,
        participantName: string,
        armourClass: number,
        maxHitPoints: number,
        dexterityModifier: number,
        startingHitPoints: number | undefined = undefined,
        currentHitPoints: number | undefined = undefined,
        initiative: number | undefined = undefined,
        temporaryId: number | undefined = undefined,
        participantType: ParticipantTypeEnum,
    ) {
        this._id = id;
        this._participantName = participantName;
        this._armourClass = armourClass;
        this._maxHitPoints = maxHitPoints;
        this._dexterityModifier = dexterityModifier;
        this._startingHitPoints = startingHitPoints ?? this.maxHitPoints;
        this._currentHitPoints = currentHitPoints ?? this.startingHitPoints;
        this._participantType = participantType;
        this._initiative = initiative;
        if (typeof temporaryId === 'undefined') {
            temporaryId = this.createTemporaryId();
        }
        this._temporaryId = temporaryId;
    }

    get id(): number {
        return this._id;
    }

    get participantName(): string {
        return this._participantName;
    }

    // set participantName(value: string) {
    //     this._participantName = value;
    // }

    get armourClass(): number {
        return this._armourClass;
    }

    // set armourClass(value: number) {
    //     this._armourClass = value;
    // }

    get maxHitPoints(): number {
        return this._maxHitPoints;
    }

    // set maxHitPoints(value: number) {
    //     this._maxHitPoints = value;
    // }

    get dexterityModifier(): number {
        return this._dexterityModifier;
    }

    // set dexterityModifier(value: number) {
    //     this._dexterityModifier = value;
    // }

    get temporaryId(): number {
        return this._temporaryId;
    }

    // set temporaryId(temporaryId: number) {
    //     this._temporaryId = temporaryId;
    // }

    get startingHitPoints(): number {
        return this._startingHitPoints;
    }

    set startingHitPoints(startingHitPoints: number) {
        this._startingHitPoints = startingHitPoints;
    }

    get currentHitPoints(): number {
        return this._currentHitPoints;
    }

    set currentHitPoints(newHitPoints: number) {
        this._currentHitPoints = newHitPoints;
    }

    get initiative(): number | undefined {
        return this._initiative;
    }

    set initiative(initiative: number) {
        this._initiative = initiative;
    }

    get participantType(): ParticipantTypeEnum {
        return this._participantType;
    }

    /*
     * Create a number that is 10 characters long and assign it to tempId
     */
    private createTemporaryId(): number {
        let milliseconds = Date.now().toString();
        milliseconds = milliseconds.substring(milliseconds.length - 4);

        const randomNumber = Math.floor(1000 + Math.random() * 9999).toString();

        return parseInt(randomNumber + milliseconds);
    }

    public getState(): ParticipantAbstractStateInterface {
        return {
            Id: this.id,
            ParticipantName: this.participantName,
            ArmourClass: this.armourClass,
            MaxHitPoints: this.maxHitPoints,
            DexterityModifier: this.dexterityModifier,
            StartingHitPoints: this.startingHitPoints,
            CurrentHitPoints: this.currentHitPoints,
            Initiative: this.initiative,
            ParticipantType: this.participantType,
            TemporaryId: this.temporaryId,
        };
    }
}

export interface ParticipantAbstractStateInterface {
    Id: number;
    ParticipantName: string;
    ArmourClass: number;
    MaxHitPoints: number;
    DexterityModifier: number;
    StartingHitPoints: number;
    CurrentHitPoints: number;
    Initiative: number | undefined;
    ParticipantType: ParticipantTypeEnum;
    TemporaryId: number;
}
