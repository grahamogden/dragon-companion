import RestClientService from '../../repository/rest/RestClientService.js'
import type MonsterRepositoryInterface from '../MonsterRepositoryInterface.ts'
import type { NewMonsterEntityInterface, MonsterEntityInterface } from '../index.js'

export default class MonsterRestRepository implements MonsterRepositoryInterface {
    private restClient: RestClientService
    private readonly route: string = 'api/v1/campaigns/{campaignId}/monsters'

    public constructor(restClient: RestClientService) {
        this.restClient = restClient
    }

    public async findByIdAndCampaignId(
        campaignId: number,
        id: number,
    ): Promise<MonsterEntityInterface | null> {
        const res = await this.restClient.get(this.getRoute(campaignId) + '/' + id)
        let monsterResponse: MonsterEntityInterface = await res.json()
        return monsterResponse
    }

    public async findAll(campaignId: number): Promise<MonsterEntityInterface[]> {
        const res = await this.restClient.get(this.getRoute(campaignId))
        return await res.json()
    }

    public async add(campaignId: number, monster: NewMonsterEntityInterface): Promise<number> {
        const res = await this.restClient.post(this.getRoute(campaignId), monster)
        if (res.ok) {
            const monsterResponse = await res.json()
            return monsterResponse.id
        }
        throw new Error()
    }

    public async update(campaignId: number, monster: MonsterEntityInterface): Promise<void> {
        const res = await this.restClient.put(this.getRoute(campaignId) + '/' + monster.id, monster)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    public async delete(campaignId: number, monsterId: number): Promise<void> {
        const res = await this.restClient.delete(this.getRoute(campaignId) + '/' + monsterId)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    private getRoute(campaignId: number): string {
        return this.route.replace('{campaignId}', campaignId.toString())
    }
}
