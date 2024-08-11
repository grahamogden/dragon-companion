import RestClientService from '../../repository/rest/RestClientService'
import type ItemRepositoryInterface from '../ItemRepositoryInterface'
import type { NewItemEntityInterface, ItemEntityInterface } from '../index.js'

export default class ItemRestRepository implements ItemRepositoryInterface {
    private restClient: RestClientService
    private readonly route: string = 'api/v1/campaigns/{campaignId}/items'

    public constructor(restClient: RestClientService) {
        this.restClient = restClient
    }

    public async findByIdAndCampaignId(
        campaignId: number,
        id: number,
    ): Promise<ItemEntityInterface | null> {
        const res = await this.restClient.get(this.getRoute(campaignId) + '/' + id)
        let itemResponse: ItemEntityInterface = await res.json()
        return itemResponse
    }

    public async findAll(campaignId: number): Promise<ItemEntityInterface[]> {
        const res = await this.restClient.get(this.getRoute(campaignId))
        return await res.json()
    }

    public async add(campaignId: number, item: NewItemEntityInterface): Promise<number> {
        const res = await this.restClient.post(this.getRoute(campaignId), item)
        if (res.ok) {
            const itemResponse = await res.json()
            return itemResponse.id
        }
        throw new Error()
    }

    public async update(campaignId: number, item: ItemEntityInterface): Promise<void> {
        const res = await this.restClient.put(this.getRoute(campaignId) + '/' + item.id, item)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    public async delete(campaignId: number, itemId: number): Promise<void> {
        const res = await this.restClient.delete(this.getRoute(campaignId) + '/' + itemId)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    private getRoute(campaignId: number): string {
        return this.route.replace('{campaignId}', campaignId.toString())
    }
}
