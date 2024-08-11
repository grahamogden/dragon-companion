import { defineStore } from 'pinia'

interface ConfigurationStoreInterface {
    isBodyFixed: boolean
}

export const useConfigurationStore = defineStore('configuration', {
    state: (): ConfigurationStoreInterface => ({
        isBodyFixed: false,
    }),
    getters: {},
    actions: {
        setIsBodyFixed(isFixed: boolean) {
            this.isBodyFixed = isFixed
        },
    },
})
