import { defineStore } from 'pinia'
import { useLocalStorage, type RemovableRef } from '@vueuse/core'
import type CampaignEntityInterface from '../services/campaign/CampaignEntityInterface'
import CampaignRestRepository from '@/services/campaign/rest/CampaignRestRepository'

interface CampaignStoreInterface {
    campaignId: RemovableRef<number | null>
    campaignName: RemovableRef<string | null>
    campaigns: RemovableRef<CampaignEntityInterface[]>
}

export const useCampaignStore = defineStore('campaign', {
    state: (): CampaignStoreInterface => ({
        campaignId: useLocalStorage<number | null>('campaignId', null),
        campaignName: useLocalStorage<string | null>('campaignName', null),
        campaigns: useLocalStorage<CampaignEntityInterface[]>('campaigns', []),
    }),
    getters: {
        isCampaignSelected: (state) => state.campaignId !== null,
        selectedCampaignId: (state) => state.campaignId,
        selectedCampaignName: (state) => state.campaignName,
        getCampaignById: (state) => {
            return (campaignId: number) =>
                state.campaigns.find((campaign) => campaign.id === campaignId)
        },
    },
    actions: {
        _getCampaignRespository(): CampaignRestRepository {
            return new CampaignRestRepository(this.restClient)
        },
        selectCampaign(campaignId: number | null): number | null {
            if (campaignId === null) {
                return this.campaignId
            }

            this.campaigns.forEach((campaign) => {
                if (campaign.id === campaignId) {
                    this.campaignId = campaign.id
                    this.campaignName = campaign.name
                    return
                }
            })
            return this.campaignId
        },
        async fetchCampaigns(): Promise<CampaignEntityInterface[]> {
            this._resetCampaigns()

            console.debug('Fetching campaigns in store')

            const campaignsResponse = await this._getCampaignRespository().findAllByUser()
            campaignsResponse?.forEach((campaignResponse) => {
                this.campaigns.push(campaignResponse)
            })
            return this.campaigns
        },
        async addCampaign(campaign: { name: string; synopsis: string }) {
            const campaignId = await this._getCampaignRespository().add(campaign)
            const newCampaign: CampaignEntityInterface = {
                id: campaignId,
                ...campaign,
            }
            this.campaigns.push(newCampaign)
        },
        async updateCampaign(campaign: CampaignEntityInterface) {
            await this._getCampaignRespository().update(campaign)
            this.campaigns = this.campaigns.filter(
                (campaignCheck) => campaignCheck.id !== campaign.id,
            )
            this.campaigns.push(campaign)
        },
        async deleteCampaign(campaignId: number) {
            await this._getCampaignRespository().delete(campaignId)
            this.campaigns = this.campaigns.filter((campaign) => campaign.id !== campaignId)
        },
        _resetCampaigns() {
            console.debug('Reset campaigns in store')
            this.campaigns = []
        },
        reset() {
            this._resetCampaigns()
            this.$reset()
        },
    },
})
