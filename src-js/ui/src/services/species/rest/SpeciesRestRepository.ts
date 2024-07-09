import RestClientService from '../../repository/rest/RestClientService'
import type { NewSpeciesEntityInterface } from '../SpeciesEntityInterface'
import { type SpeciesEntityInterface } from '../SpeciesEntityInterface'
import type SpeciesRepositoryInterface from '../SpeciesRepositoryInterface'

export default class SpeciesRestRepository implements SpeciesRepositoryInterface {
    private restClient: RestClientService
    private readonly route: string = 'api/v1/campaigns/{campaignId}/species'

    public constructor(restClient: RestClientService) {
        this.restClient = restClient
    }

    public async findByIdAndCampaignId(
        campaignId: number,
        id: number,
    ): Promise<SpeciesEntityInterface | null> {
        const res = await this.restClient.get(this.getRoute(campaignId) + '/' + id)
        let speciesResponse: SpeciesEntityInterface = await res.json()
        return speciesResponse
    }

    public async findAll(campaignId: number): Promise<SpeciesEntityInterface[]> {
        const res = await this.restClient.get(this.getRoute(campaignId))
        return await res.json()
    }

    public async add(campaignId: number, species: NewSpeciesEntityInterface): Promise<number> {
        const res = await this.restClient.post(this.getRoute(campaignId), species)
        if (res.ok) {
            const speciesResponse = await res.json()
            return speciesResponse.id
        }
        throw new Error()
    }

    public async update(campaignId: number, species: SpeciesEntityInterface): Promise<void> {
        const res = await this.restClient.put(this.getRoute(campaignId) + '/' + species.id, species)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    public async delete(campaignId: number, speciesId: number): Promise<void> {
        const res = await this.restClient.delete(this.getRoute(campaignId) + '/' + speciesId)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    private getRoute(campaignId: number): string {
        return this.route.replace('{campaignId}', campaignId.toString())
    }
}
