import RestClientService from '../../repository/rest/RestClientService.js'
import type CharacterRepositoryInterface from '../CharacterRepositoryInterface.js'
import type { NewCharacterEntityInterface, CharacterEntityInterface } from '../index.js'

export default class CharacterRestRepository implements CharacterRepositoryInterface {
    private restClient: RestClientService
    private readonly route: string = 'api/v1/campaigns/{campaignId}/characters'

    public constructor(restClient: RestClientService) {
        this.restClient = restClient
    }

    public async findByIdAndCampaignId(
        campaignId: number,
        id: number,
    ): Promise<CharacterEntityInterface | null> {
        const res = await this.restClient.get(this.getRoute(campaignId) + '/' + id)
        let characterResponse: CharacterEntityInterface = await res.json()
        return characterResponse
    }

    public async findAll(campaignId: number): Promise<CharacterEntityInterface[]> {
        const res = await this.restClient.get(this.getRoute(campaignId))
        return await res.json()
    }

    public async add(campaignId: number, character: NewCharacterEntityInterface): Promise<number> {
        const res = await this.restClient.post(this.getRoute(campaignId), character)
        if (res.ok) {
            const characterResponse = await res.json()
            return characterResponse.id
        }
        throw new Error()
    }

    public async update(campaignId: number, character: CharacterEntityInterface): Promise<void> {
        const res = await this.restClient.put(
            this.getRoute(campaignId) + '/' + character.id,
            character,
        )
        if (res.ok) {
            return
        }
        throw new Error()
    }

    public async delete(campaignId: number, characterId: number): Promise<void> {
        const res = await this.restClient.delete(this.getRoute(campaignId) + '/' + characterId)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    private getRoute(campaignId: number): string {
        return this.route.replace('{campaignId}', campaignId.toString())
    }
}
