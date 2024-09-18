import type { EntityInterface } from "../entity.interface";

export interface CampaignEntityInterface
    extends EntityInterface,
        NewCampaignEntityInterface {}

export interface NewCampaignEntityInterface {
    name: string;
    synopsis: string;
}
