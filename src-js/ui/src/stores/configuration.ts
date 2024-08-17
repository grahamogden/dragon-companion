import { useLocalStorage, type RemovableRef } from '@vueuse/core'
import { defineStore } from 'pinia'

export enum ThemeEnum {
    AUTO = 'auto',
    LIGHT = 'light',
    DARK = 'dark',
}

interface ConfigurationStoreInterface {
    isBodyFixed: boolean
    theme: RemovableRef<ThemeEnum>
}

export const useConfigurationStore = defineStore('configuration', {
    state: (): ConfigurationStoreInterface => ({
        isBodyFixed: false,
        theme: useLocalStorage<ThemeEnum>('theme', ThemeEnum.AUTO),
    }),
    getters: {},
    actions: {
        setIsBodyFixed(isFixed: boolean) {
            this.isBodyFixed = isFixed
        },
        setTheme(theme: ThemeEnum) {
            this.theme = theme
        },
    },
})
