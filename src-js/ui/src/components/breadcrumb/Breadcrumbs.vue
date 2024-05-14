<script setup lang="ts">
import { useRoute } from 'vue-router'
const route = useRoute()
const path = route.fullPath

console.debug(path)
const breadcrumbs = path.split('/')
breadcrumbs[0] = 'home'
console.debug(breadcrumbs)
</script>

<template>
    <div class="breadcrumb-container">
        <div class="breadcrumb inline-block" v-for="breadcrumb in breadcrumbs">
            <a>{{ breadcrumb }}</a>>
        </div>
    </div>
</template>
