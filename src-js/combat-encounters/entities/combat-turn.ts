export class CombatTurnEntity {
    // public sourceTempId: number;
    // public targetTempId: number;
    // public action: string;
    // public roll: number;
    // public total: number;
    // public movement: number;
    // public roundNumber: number;
    // public turnNumber: number;

    constructor(
        public sourceTempId: number,
        public targetTempId: number | null,
        public action: string,
        public roll: number,
        public total: number,
        public movement: number,
        public roundNumber: number,
        public turnNumber: number
    ) {
        // this.sourceTempId = sourceTempId;
        // this.targetTempId = targetTempId;
        // this.action = action;
        // this.roll = roll;
        // this.total = total;
        // this.movement = movement;
        // this.roundNumber = roundNumber;
        // this.turnNumber = turnNumber;
    }
}
