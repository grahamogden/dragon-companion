import { defineStore } from 'pinia'
import {
    type ItemEntityInterface,
    type NewItemEntityInterface,
} from '../../services/item/ItemEntityInterface'
import ItemRestRepository from '@/services/item/rest/ItemRestRepository'
import type ItemRepositoryInterface from '../../services/item/ItemRepositoryInterface'
import { ItemEntity } from '../../services/item'

export const useItemStore = defineStore('item', {
    actions: {
        _getItemRespository(): ItemRepositoryInterface {
            return new ItemRestRepository(this.restClient)
        },
        async getItems(campaignId: number): Promise<ItemEntityInterface[]> {
            let item: ItemEntity[] = []

            const itemResponse = await this._getItemRespository().findAll(campaignId)
            itemResponse?.forEach((itemResponse: ItemEntity) => {
                item.push(itemResponse)
            })
            return item
        },
        async getOneItem(campaignId: number, id: number): Promise<ItemEntityInterface | null> {
            return await this._getItemRespository().findByIdAndCampaignId(campaignId, id)
        },
        async addItem(campaignId: number, item: NewItemEntityInterface) {
            await this._getItemRespository().add(campaignId, item)
        },
        async updateItem(campaignId: number, item: ItemEntityInterface) {
            await this._getItemRespository().update(campaignId, item)
        },
        async deleteItem(campaignId: number, itemId: number) {
            await this._getItemRespository().delete(campaignId, itemId)
        },
    },
})
