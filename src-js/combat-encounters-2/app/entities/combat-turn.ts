export class CombatTurnEntity {
    constructor(
        public sourceTemporaryId: number,
        public targetTemporaryId: number | null,
        public action: string,
        public roll: number,
        public total: number,
        public movement: number,
        public roundNumber: number,
        public turnNumber: number,
    ) {}
}
