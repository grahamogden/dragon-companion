import type RepositoryInterface from '../repository/RepositoryInterface.js'
import {
    type MonsterEntityInterface,
    type NewMonsterEntityInterface,
} from './MonsterEntityInterface.ts'

export default interface MonsterRepositoryInterface extends RepositoryInterface {
    findByIdAndCampaignId(id: number, campaignId: number): Promise<MonsterEntityInterface | null>
    findAll(campaignId: number): Promise<MonsterEntityInterface[]>
    add(campaignId: number, item: NewMonsterEntityInterface): Promise<number>
    update(campaignId: number, item: MonsterEntityInterface): Promise<void>
    delete(campaignId: number, itemId: number): Promise<void>
}
