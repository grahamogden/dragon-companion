import RestClientService from '../../repository/rest/RestClientService'
import type CampaignEntityInterface from '../CampaignEntityInterface'
import type CampaignRepositoryInterface from '../CampaignRepositoryInterface'

export default class CampaignRestRepository implements CampaignRepositoryInterface {
    private restClient: RestClientService
    private readonly route: string = 'api/v1/campaigns'

    public constructor(restClient: RestClientService) {
        this.restClient = restClient
    }

    public async findById(id: number): Promise<CampaignEntityInterface | null> {
        const res = await this.restClient.get(this.route)
        let campaignResponse: CampaignEntityInterface = await res.json()
        return campaignResponse
    }

    public async findAllByUser(): Promise<CampaignEntityInterface[] | null> {
        const res = await this.restClient.get(this.route)
        let campaignsResponse: CampaignEntityInterface[] = await res.json()
        return campaignsResponse
    }

    public async add(data: { name: string; synopsis: string }): Promise<number> {
        const res = await this.restClient.post(this.route, data)
        if (res.ok) {
            const campaignResponse = await res.json()
            return campaignResponse.id
        }
        throw new Error()
    }

    public async update(data: CampaignEntityInterface): Promise<void> {
        const res = await this.restClient.put(this.route + '/' + data.id, data)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    public async delete(campaignId: number): Promise<void> {
        const res = await this.restClient.delete(this.route + '/' + campaignId)
        if (res.ok) {
            return
        }
        throw new Error()
    }
}
