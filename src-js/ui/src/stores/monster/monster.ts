import { defineStore } from 'pinia'
import {
    type MonsterEntityInterface,
    type NewMonsterEntityInterface,
} from '../../services/monster/MonsterEntityInterface'
import MonsterRestRepository from '@/services/monster/rest/MonsterRestRepository'
import type MonsterRepositoryInterface from '../../services/monster/MonsterRepositoryInterface'
import { MonsterEntity } from '../../services/monster'

export const useMonsterStore = defineStore('monster', {
    actions: {
        _getMonsterRespository(): MonsterRepositoryInterface {
            return new MonsterRestRepository(this.restClient)
        },
        async getMonsters(campaignId: number): Promise<MonsterEntityInterface[]> {
            let monster: MonsterEntity[] = []

            const monsterResponse = await this._getMonsterRespository().findAll(campaignId)
            monsterResponse?.forEach((monsterResponse: MonsterEntity) => {
                monster.push(monsterResponse)
            })
            return monster
        },
        async getOneMonster(
            campaignId: number,
            id: number,
        ): Promise<MonsterEntityInterface | null> {
            return await this._getMonsterRespository().findByIdAndCampaignId(campaignId, id)
        },
        async addMonster(campaignId: number, monster: NewMonsterEntityInterface) {
            await this._getMonsterRespository().add(campaignId, monster)
        },
        async updateMonster(campaignId: number, monster: MonsterEntityInterface) {
            await this._getMonsterRespository().update(campaignId, monster)
        },
        async deleteMonster(campaignId: number, monsterId: number) {
            await this._getMonsterRespository().delete(campaignId, monsterId)
        },
    },
})
