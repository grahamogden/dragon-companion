import { defineStore } from 'pinia'
import {
    type CharacterEntityInterface,
    type NewCharacterEntityInterface,
} from '../../services/character/CharacterEntityInterface'
import CharacterRestRepository from '@/services/character/rest/CharacterRestRepository'
import type CharacterRepositoryInterface from '../../services/character/CharacterRepositoryInterface'
import { CharacterEntity } from '../../services/character'

export const useCharacterStore = defineStore('character', {
    actions: {
        _getCharacterRespository(): CharacterRepositoryInterface {
            return new CharacterRestRepository(this.restClient)
        },
        async getCharacters(campaignId: number): Promise<CharacterEntityInterface[]> {
            let character: CharacterEntity[] = []

            const characterResponse = await this._getCharacterRespository().findAll(campaignId)
            characterResponse?.forEach((characterResponse: CharacterEntity) => {
                character.push(characterResponse)
            })
            return character
        },
        async getOneCharacter(
            campaignId: number,
            id: number,
        ): Promise<CharacterEntityInterface | null> {
            return await this._getCharacterRespository().findByIdAndCampaignId(campaignId, id)
        },
        async addCharacter(campaignId: number, character: NewCharacterEntityInterface) {
            await this._getCharacterRespository().add(campaignId, character)
        },
        async updateCharacter(campaignId: number, character: CharacterEntityInterface) {
            await this._getCharacterRespository().update(campaignId, character)
        },
        async deleteCharacter(campaignId: number, characterId: number) {
            await this._getCharacterRespository().delete(campaignId, characterId)
        },
    },
})
