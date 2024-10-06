import { defineStore } from "pinia";
import { useLocalStorage, type RemovableRef } from "@vueuse/core";

interface CampaignStoreInterface {
    campaignId: RemovableRef<string | number | null>; // string | number | null
    campaignName: RemovableRef<string | null>; // string | null
}

export const useCampaignStore = defineStore("campaign", {
    state: (): CampaignStoreInterface => ({
        campaignId: useLocalStorage<number | null>("campaignId", null),
        campaignName: useLocalStorage<string | null>("campaignName", null),
    }),
    getters: {
        isCampaignSelected: (state) => state.campaignId !== null,
        selectedCampaignId: (state) =>
            state.campaignId !== null
                ? parseInt(state.campaignId as string)
                : null,
        selectedCampaignName: (state) => state.campaignName,
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

            this.campaignId = campaignId;
            this.campaignName = campaignName;

            return parseInt(this.campaignId as unknown as string);
        },
        reset() {
            console.debug("Resetting campaign store");
            this.campaignId = null;
            this.campaignName = null;
            this.$reset();
        },
    },
});
