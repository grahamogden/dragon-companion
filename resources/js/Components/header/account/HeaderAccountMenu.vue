<script setup lang="ts">
    import { ref } from 'vue';
    import { useConfigurationStore } from '../../../stores/index';
    import DropDownMenu from '../../drop-down/DropDownMenu.vue';
    import KebabMenuItemLink from '../../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';
    import KebabMenuItemButton from '../../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';

    const configStore = useConfigurationStore()

    const isAccountMenuOpen = ref(false)
    function toggleAccountMenu(open?: boolean) {
        isAccountMenuOpen.value = open ?? !isAccountMenuOpen.value
        configStore.setOverlayActive(isAccountMenuOpen.value)
    }

    // const logOut = () => {
    //     const auth = getAuth(inject(firebaseAppKey));
    //     campaignStore.reset()

    //     signOut(auth).then(() => {
    //         console.debug(('Logged out'));
    //         const userAuthStore = useUserAuthStore()
    //         userAuthStore.$reset()

    //         route().push('/login')
    //     }).catch((error) => {
    //         console.error(error)
    //     });
    // }
</script>
<template>
    <DropDownMenu button-aria-context-name="Account">
        <template #button-content>
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-timberwolf-50 bg-stone-800 p-0"
                type="button">
                <img class="logo w-full h-full" src="@/assets/logo.svg" alt="User account picture" />
            </div>
        </template>
        <template #items>
            <KebabMenuItemLink class="drop-down-menu-item" v-if="$page.props.auth.user"
                :destination="{ name: 'user-account' }"><font-awesome-icon :icon="['fas', 'circle-user']" fixed-width
                    class="mr-2" />My account</KebabMenuItemLink>
            <KebabMenuItemButton class="drop-down-menu-item" :func="() => { toggleAccountMenu(false); logOut(); }"
                :args="[]" type="button">
                <font-awesome-icon :icon="['fas', 'right-from-bracket']" fixed-width class="mr-2" />Log Out
            </KebabMenuItemButton>
        </template>
    </DropDownMenu>
</template>

<style>

    .menu-slide-out-enter-from,
    .menu-slide-out-leave-to {
        line-height: 0;
        font-size: 0;
    }

    .menu-slide-out-enter-from a,
    .menu-slide-out-leave-to a,
    .menu-slide-out-enter-from button,
    .menu-slide-out-leave-to button {
        padding: 0;
    }

    .menu-slide-out-enter-active,
    .menu-slide-out-leave-active,
    .menu-slide-out-enter-active a,
    .menu-slide-out-leave-active a,
    .menu-slide-out-enter-active button,
    .menu-slide-out-leave-active button {
        transition-property: padding, line-height, font-size;
        transition-duration: 0.1s;
        transition-timing-function: ease;
        transition-delay: 0ms;
    }

    .menu-slide-out-enter-to,
    .menu-slide-out-leave-from {
        line-height: normal;
        font-size: normal;
    }
</style>