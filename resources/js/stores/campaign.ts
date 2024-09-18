import { defineStore } from "pinia";
import { useLocalStorage, type RemovableRef } from "@vueuse/core";
import {
    CampaignEntity,
    type CampaignEntityInterface,
} from "../types/entities/campaign/index.ts";

interface CampaignStoreInterface {
    campaignId: RemovableRef<string | number | null>; // string | number | null
    campaignName: RemovableRef<string | null>; // string | null
    campaigns: RemovableRef<CampaignEntityInterface[]>; // CampaignEntityInterface[]
}

export const useCampaignStore = defineStore("campaign", {
    state: (): CampaignStoreInterface => ({
        campaignId: useLocalStorage<number | null>("campaignId", null),
        campaignName: useLocalStorage<string | null>("campaignName", null),
        campaigns: useLocalStorage<CampaignEntityInterface[]>("campaigns", []),
    }),
    getters: {
        isCampaignSelected: (state) => state.campaignId !== null,
        selectedCampaignId: (state) =>
            state.campaignId !== null
                ? parseInt(state.campaignId as string)
                : null,
        selectedCampaignName: (state) => state.campaignName,
        getCampaignById: (state) => {
            return (campaignId: number) =>
                state.campaigns.find((campaign) => campaign.id === campaignId);
        },
    },
    actions: {
        selectCampaign(
            campaignId: number | null,
            campaignName: string | null
        ): number | null {
            if (campaignId === null) {
                this.campaignId = null;
                this.campaignName = null;
                return this.campaignId;
            }

            // this.campaigns.forEach((campaign) => {
            //     if (campaign.id === campaignId) {
            this.campaignId = campaignId;
            this.campaignName = campaignName;
            //         return;
            //     }
            // });

            return parseInt(this.campaignId as unknown as string);
        },
        async getCampaigns(): Promise<CampaignEntityInterface[]> {
            this.campaigns = [];

            console.debug("Fetching campaigns in store");

            // const campaignsResponse =
            //     await this._getCampaignRespository().findAllByUser();
            // campaignsResponse?.forEach((campaignResponse) => {
            //     this.campaigns.push(campaignResponse);
            // });
            return this.campaigns;
        },
        async addCampaign(campaign: { name: string; synopsis: string }) {
            // const campaignId = await this._getCampaignRespository().add(
            //     campaign
            // );
            // const newCampaign: CampaignEntityInterface = new CampaignEntity(
            //     campaignId,
            //     campaign.name,
            //     campaign.synopsis
            // );
            // this.campaigns.push(newCampaign);
        },
        async updateCampaign(campaign: CampaignEntityInterface) {
            // await this._getCampaignRespository().update(campaign);
            // this.campaigns = this.campaigns.filter(
            //     (campaignCheck) => campaignCheck.id !== campaign.id
            // );
            // this.campaigns.push(campaign);
        },
        async deleteCampaign(campaignId: number) {
            // await this._getCampaignRespository().delete(campaignId);
            // this.campaigns = this.campaigns.filter(
            //     (campaign) => campaign.id !== campaignId
            // );
        },
        reset() {
            console.debug("Resetting campaign store");
            this.campaigns = [];
            this.campaignId = null;
            this.campaignName = null;
            this.$reset();
        },
    },
});
