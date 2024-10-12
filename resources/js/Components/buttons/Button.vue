<script setup lang="ts">
    import { PropType } from 'vue';
    import { ButtonSeverity } from './button-severity';

    const emit = defineEmits(['button:on-click']);
    const props = defineProps({
        type: { type: String as PropType<'button' | 'submit'>, required: false, default: 'submit' },
        severity: { type: String as PropType<ButtonSeverity>, required: false, default: ButtonSeverity.primary },
        isDefaultMinWidth: { type: Boolean, required: false, default: false },
        rounded: { type: Boolean, required: false, default: false },
        outlined: { type: Boolean, required: false, default: false },
        disabled: { type: Boolean, required: false, default: false },
        icon: { type: Array as PropType<string[] | null>, required: false, default: null },
        ariaLabel: { type: String, required: false },
    })

    function onClick() {
        emit('button:on-click')
    }
</script>
<template>
    <div class="button-wrapper w-full md:w-auto overflow-hidden transition-colors duration-theme-change" :class="{
        'success': severity === ButtonSeverity.success,
        'danger': severity === ButtonSeverity.danger,
        'primary': severity === ButtonSeverity.primary,
        'rounded-full': rounded,
        'outlined': outlined,
        'disabled': disabled,
    }">
        <button v-if="type === 'submit'"
            class="button relative w-full d:w-auto text-center text-lg no-underline duration-0" :class="{
                'is-default-min-width': isDefaultMinWidth
            }" :disabled="disabled" type="submit" :aria-label="ariaLabel">
            <font-awesome-icon v-if="icon" :icon="icon" fixed-width class="mr-2"></font-awesome-icon>
            <slot>Submit</slot>
        </button>
        <button v-else class="button relative w-full d:w-auto text-center text-lg no-underline duration-0" :class="{
            'is-default-min-width': isDefaultMinWidth
        }" :disabled="disabled" :type="type" @click.prevent="onClick" :aria-label="ariaLabel">
            <font-awesome-icon v-if="icon" :icon="icon" fixed-width class="mr-2"></font-awesome-icon>
            <slot>Submit</slot>
        </button>
    </div>
</template>