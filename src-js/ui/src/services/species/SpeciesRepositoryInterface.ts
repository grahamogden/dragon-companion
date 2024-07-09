import type RepositoryInterface from '../repository/RepositoryInterface'
import {
    type SpeciesEntityInterface,
    type NewSpeciesEntityInterface,
} from './SpeciesEntityInterface'

export default interface SpeciesRepositoryInterface extends RepositoryInterface {
    findByIdAndCampaignId(id: number, campaignId: number): Promise<SpeciesEntityInterface | null>
    findAll(campaignId: number): Promise<SpeciesEntityInterface[]>
    add(campaignId: number, species: NewSpeciesEntityInterface): Promise<number>
    update(campaignId: number, species: SpeciesEntityInterface): Promise<void>
    delete(campaignId: number, speciesId: number): Promise<void>
}
