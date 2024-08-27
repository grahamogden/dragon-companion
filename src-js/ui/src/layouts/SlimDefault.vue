<script setup lang="ts">
    import Breadcrumbs from '../components/breadcrumbs/Breadcrumbs.vue'
    import BannerContainer from '../components/alert-banner/BannerContainer.vue'

</script>
<template>
    <div class="max-w-slim-content w-full m-0 mb-32 md:mx-auto md:my-default-md md:px-default-md">
        <div class="flex flex-row content-stretch rounded-3xl shadow-lg">
            <div
                class="relative w-full h-full p-default md:p-default-md before:content-[''] before:absolute before:top-0 before:left-0 before:w-full before:h-full before:bg-timberwolf-50/80 before:dark:bg-woodsmoke-950/80 before:backdrop-blur-xl before:md:rounded-3xl before:duration-theme-change">
                <div class="relative w-full">
                    <BannerContainer></BannerContainer>
                    <Breadcrumbs></Breadcrumbs>
                </div>
                <main id="main-content" class="relative w-full h-full">
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>