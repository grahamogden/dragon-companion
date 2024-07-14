<script setup lang="ts">
    import { ref, watch } from 'vue';
    import { useRoute, RouterLink } from 'vue-router'
    const route = useRoute()
    const path = route.path

    const breadcrumbs = ref<{ text: string, destination: string }[]>([]);

    function updateBreadcrumbs(breadcrumbPaths: string[]) {
        // Reset array and add home
        breadcrumbs.value = []
        let breadcrumbBasePath = ''
        breadcrumbs.value[0] = { text: 'home', destination: '/' }

        // Add breadcrumb objects to array
        breadcrumbPaths
        .filter(Boolean)
        .forEach((breadcrumbPath) => {
            breadcrumbBasePath = breadcrumbBasePath.concat('/' + breadcrumbPath)
            if (isNaN(parseFloat(breadcrumbPath))) {
                breadcrumbs.value.push({
                    text: breadcrumbPath,
                    destination: breadcrumbBasePath
                })
            }
        })
        breadcrumbs.value[breadcrumbs.value.length - 1].destination = ''
    }

    updateBreadcrumbs(path.split('/'))

    watch(() => route.fullPath, (newRoute, oldRoute) => {
        updateBreadcrumbs(newRoute.split('/'))
    })
</script>

<template>
    <div class="breadcrumb-container mb-4">
        <div class="breadcrumb inline-block" v-for="breadcrumb in breadcrumbs">
            <router-link v-if="breadcrumb.destination" :to="breadcrumb.destination" class="capitalize">{{ breadcrumb.text }}</router-link>
            <span v-else class="capitalize">{{ breadcrumb.text }}</span>
        </div>
    </div>
</template>
