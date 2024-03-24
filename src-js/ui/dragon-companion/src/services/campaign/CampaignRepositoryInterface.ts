import type RepositoryInterface from '../repository/RepositoryInterface'
import type CampaignEntityInterface from './CampaignEntityInterface'

export default interface CampaignRepositoryInterface extends RepositoryInterface {
  findById(id: number, authToken: string): Promise<CampaignEntityInterface | null>
  findAllByUser(authToken: string): Promise<CampaignEntityInterface[] | null>
}
