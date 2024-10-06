<script setup lang="ts">
    import { computed, PropType, defineEmits } from 'vue'
    import { v4 as uuidv4 } from 'uuid'

    const emit = defineEmits(['update:checked']);

    const props = defineProps({
        checked: { type: Boolean as PropType<boolean> },
        value: { required: false },
        disabled: { type: Boolean as PropType<boolean>, required: false, default: false },
    });

    const proxyChecked = computed({
        get() {
            return props.checked;
        },

        set(val: boolean) {
            emit('update:checked', val, props.value);
        },
    });

    const id = uuidv4();
</script>

<template>
    <div class="flex grid-cols-2 gap-2 justify-between">
        <div class="flex items-center w-max"><input type="checkbox" :value="value" v-model="proxyChecked"
                :disabled="!!disabled"
                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed"
                :id="id" />
        </div>
        <div class="w-full">
            <label :for="id">
                <slot></slot>
            </label>
        </div>
    </div>
</template>
