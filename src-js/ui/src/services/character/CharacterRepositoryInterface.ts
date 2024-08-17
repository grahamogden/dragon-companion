import type RepositoryInterface from '../repository/RepositoryInterface.js'
import {
    type CharacterEntityInterface,
    type NewCharacterEntityInterface,
} from './CharacterEntityInterface.js'

export default interface CharacterRepositoryInterface extends RepositoryInterface {
    findByIdAndCampaignId(id: number, campaignId: number): Promise<CharacterEntityInterface | null>
    findAll(campaignId: number): Promise<CharacterEntityInterface[]>
    add(campaignId: number, item: NewCharacterEntityInterface): Promise<number>
    update(campaignId: number, item: CharacterEntityInterface): Promise<void>
    delete(campaignId: number, itemId: number): Promise<void>
}
