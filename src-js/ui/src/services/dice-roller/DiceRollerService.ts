export default class DiceRoller {
    public currentRoll: number | undefined

    constructor(private readonly limit: number) {}

    public roll(): number {
        this.currentRoll = Math.floor(Math.random() * this.limit) + 1

        return this.currentRoll
    }
}
