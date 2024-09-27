import type { EntityInterface } from "../entity.interface";

export interface NewCampaignEntityInterface {
    name: string;
    synopsis: string;
}

export interface CampaignEntityInterface
    extends EntityInterface,
        NewCampaignEntityInterface {}
