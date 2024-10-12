import { useLocalStorage, type RemovableRef } from "@vueuse/core";
import { defineStore } from "pinia";

export enum ThemeEnum {
    AUTO = "auto",
    LIGHT = "light",
    DARK = "dark",
}

interface ConfigurationStoreInterface {
    isBodyFixed: boolean;
    isOverlayActive: boolean;
    theme: RemovableRef<ThemeEnum>;
}

export const useConfigurationStore = defineStore("configuration", {
    state: (): ConfigurationStoreInterface => ({
        isBodyFixed: false,
        isOverlayActive: false,
        theme: useLocalStorage<ThemeEnum>("theme", ThemeEnum.AUTO),
    }),
    getters: {},
    actions: {
        isSmallScreen(): boolean {
            return window.innerWidth < 768;
        },
        setIsBodyFixed(isFixed: boolean): void {
            this.isBodyFixed = this.isSmallScreen() && isFixed;
        },
        setTheme(theme: ThemeEnum): void {
            this.theme = theme;
        },
        setOverlayActive(isActive: boolean): void {
            this.setIsBodyFixed(isActive);
            this.isOverlayActive = isActive;
        },
    },
});
