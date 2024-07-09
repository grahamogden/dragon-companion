import { defineStore } from 'pinia'
import { useLocalStorage, type RemovableRef } from '@vueuse/core'
import {
    type SpeciesEntityInterface,
    type NewSpeciesEntityInterface,
} from '../services/species/SpeciesEntityInterface'
import SpeciesRestRepository from '@/services/species/rest/SpeciesRestRepository'
import type SpeciesRepositoryInterface from '../services/species/SpeciesRepositoryInterface'
import { SpeciesEntity } from '../services/species'

// interface SpeciesStoreInterface {
//     speciesId: RemovableRef<number | null>
//     speciesName: RemovableRef<string | null>
//     speciess: RemovableRef<SpeciesEntityInterface[]>
// }

export const useSpeciesStore = defineStore('species', {
    // state: (): SpeciesStoreInterface => ({
    // }),
    // getters: {
    //     isSpeciesSelected: (state) => state.speciesId !== null,
    //     selectedSpeciesId: (state) => state.speciesId,
    //     selectedSpeciesName: (state) => state.speciesName,
    //     getSpeciesById: (state) => {
    //         return (speciesId: number) => state.speciess.find((species) => species.id === speciesId)
    //     },
    // },
    actions: {
        _getSpeciesRespository(): SpeciesRepositoryInterface {
            return new SpeciesRestRepository(this.restClient)
        },
        async fetchSpecies(campaignId: number): Promise<SpeciesEntityInterface[]> {
            let species: SpeciesEntity[] = []

            console.debug('Fetching species in store')

            const speciesResponse = await this._getSpeciesRespository().findAll(campaignId)
            speciesResponse?.forEach((speciesResponse: SpeciesEntity) => {
                species.push(speciesResponse)
            })
            return species
        },
        async getOneSpecies(
            campaignId: number,
            id: number,
        ): Promise<SpeciesEntityInterface | null> {
            return await this._getSpeciesRespository().findByIdAndCampaignId(campaignId, id)
        },
        async addSpecies(campaignId: number, species: NewSpeciesEntityInterface) {
            const speciesId = await this._getSpeciesRespository().add(campaignId, species)
            const newSpecies: SpeciesEntityInterface = new SpeciesEntity(speciesId, species.name)
            // species.push(newSpecies)
        },
        async updateSpecies(campaignId: number, species: SpeciesEntityInterface) {
            await this._getSpeciesRespository().update(campaignId, species)
            // species.filter((speciesCheck) => speciesCheck.id !== species.id)
            // species.push(species)
        },
        async deleteSpecies(campaignId: number, speciesId: number) {
            await this._getSpeciesRespository().delete(campaignId, speciesId)
            // species.filter((species) => species.id !== speciesId)
        },
    },
})
