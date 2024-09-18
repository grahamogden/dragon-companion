<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    // import { useRoute, RouterLink } from 'vue-router'
    // const route = useRoute()
    const path = route().current() ?? ''

    const breadcrumbs = ref<{ text: string, href: string }[]>([]);

    function updateBreadcrumbs(breadcrumbPaths: string[]) {
        // Reset array and add home
        breadcrumbs.value = []
        let breadcrumbBasePath = ''
        // breadcrumbs.value[0] = { text: 'home', destination: '/' }

        // Add breadcrumb objects to array
        breadcrumbPaths
            .filter(Boolean)
            .forEach((breadcrumbPath, index) => {
                breadcrumbBasePath = breadcrumbBasePath.concat('/' + breadcrumbPath)
                if (isNaN(parseFloat(breadcrumbPath))) {
                    breadcrumbs.value.push({
                        text: breadcrumbPath,
                        href: index !== breadcrumbPaths.length - 1 ? breadcrumbBasePath : ''
                    })
                }
            })
        if (breadcrumbs.value.length > 0) {
            breadcrumbs.value[breadcrumbs.value.length - 1].href = ''
        }
    }

    updateBreadcrumbs(path.split('/'))

    // watch(() => route.path, (newRoute, oldRoute) => {
    //     updateBreadcrumbs(newRoute.split('/'))
    // })
</script>

<template>
    <div v-if="false" class="breadcrumb-container mb-4 text-sm">
        <div class="breadcrumb inline-block" v-for="breadcrumb in breadcrumbs">
            <Link v-if="breadcrumb.href" :href="breadcrumb.href" class="capitalize">{{
                breadcrumb.text }}</Link>
            <span v-else class="capitalize">{{ breadcrumb.text }}</span>
        </div>
    </div>
</template>
