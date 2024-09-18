<script setup lang="ts">
  import SideNavigation from '../Components/navigation/SideNavigation.vue'
  import Breadcrumbs from '../Components/breadcrumbs/Breadcrumbs.vue'
  import BannerContainer from '../Components/alert-banner/BannerContainer.vue'

</script>
<template>
  <div class="max-w-page w-full m-0 mb-32 md:mx-auto md:my-default-md md:px-default-md">
    <div class="flex flex-row content-stretch rounded-3xl shadow-lg">
      <SideNavigation></SideNavigation>

      <div
        class="relative w-full min-h-full p-default md:p-default-md before:content-[''] before:absolute before:top-0 before:left-0 before:w-full before:h-full before:bg-timberwolf-50/80 before:dark:bg-woodsmoke-950/80 before:backdrop-blur-xl before:md:rounded-r-3xl before:duration-theme-change">
        <div class="relative w-full">
          <BannerContainer></BannerContainer>
          <Breadcrumbs></Breadcrumbs>
        </div>
        <main id="main-content" class="relative w-full">
          <slot></slot>
        </main>
      </div>
    </div>
  </div>
</template>