<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { ButtonSeverity } from './button-severity';
    import { PropType } from 'vue';

    const props = defineProps({
        href: { type: String, required: true },
        severity: { type: String as PropType<ButtonSeverity>, required: false, default: ButtonSeverity.primary },
        isDefaultMinWidth: { type: Boolean, required: false, default: false },
        rounded: { type: Boolean, required: false, default: false },
        outlined: { type: Boolean, required: false, default: false },
        disabled: { type: Boolean, required: false, default: false },
        icon: { type: Array as PropType<string[] | null>, required: false, default: null },
    })
</script>
<template>
    <div class="button-wrapper overflow-hidden transition-colors duration-theme-change" :class="{
        'success': severity === ButtonSeverity.success,
        'danger': severity === ButtonSeverity.danger,
        'primary': severity === ButtonSeverity.primary,
        'rounded-full': rounded,
        'outlined': outlined,
        'disabled': disabled,
    }">
        <Link :href="href" class="button w-full text-center text-lg no-underline duration-0" :class="{
            'is-default-min-width': isDefaultMinWidth
        }">
        <font-awesome-icon v-if="icon" :icon="icon" fixed-width class="mr-/2"></font-awesome-icon>
        <slot></slot>
        </Link>
    </div>
</template>