<script setup lang="ts">
    // import { useCampaignStore } from '../../stores';
    import type { EntityInterface, IndexEntityInterface } from '../../types/entities/entity.interface';
    // import KebabMenu from '../menu/wrapped-kebab-menu/KebabMenu.vue';
    // import KebabMenuItemLink from '../menu/wrapped-kebab-menu/KebabMenuItemLink.vue';
    // import KebabMenuItemButton from '../menu/wrapped-kebab-menu/KebabMenuItemButton.vue';
    import { PropType, ref } from 'vue';
    import { EntityTableHeadingInterface } from './interface';
    import { Link, router } from '@inertiajs/vue3';
    // import Button from 'primevue/button';
    import Menu from 'primevue/menu';
    import Button from '../buttons/Button.vue';
    // import Button from '../buttons/Button.vue';

    // const campaignStore = useCampaignStore()

    const props = defineProps({
        fields: { type: Object as PropType<EntityTableHeadingInterface[]>, required: true },
        entity: { type: Object as PropType<EntityInterface & IndexEntityInterface & Record<string, string>>, required: true },
        // kebabMenuButtonAriaContext: { type: String, required: true },
    })

    const deleteEntity = (entity?: IndexEntityInterface & EntityInterface) => {
        if (props.entity.destroy_url) {
            if (confirm('Are you sure you want to delete this record?')) {
                router.delete(props.entity.destroy_url)
            }
        } else {
            alert('Nothing to delete!')
        }
    }
    const menu = ref();
    const items = ref([
        { label: 'Edit', command: () => { router.visit(props.entity.edit_url!) } },
        { label: 'Delete', command: deleteEntity },
    ]);

    const toggle = (event: Event) => {
        menu.value.toggle(event)
    }
</script>
<template>
    <Button type="button" @click="toggle" aria-haspopup :aria-controls="'overlay-menu-' + entity.id" rounded>
        <font-awesome-icon :icon="['fa', 'fa-ellipsis-vertical']" fixed-width></font-awesome-icon>
    </Button>
    <Menu ref="menu" :id="'overlay-menu' + entity.id" :model="items" popup />
</template>