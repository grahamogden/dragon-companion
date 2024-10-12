<script setup lang="ts">
    import { computed, defineEmits } from 'vue'
    import Checkbox from 'primevue/checkbox';

    const emit = defineEmits(['update:checked']);

    const props = defineProps({
        checked: { type: Boolean },
        value: { required: false },
        disabled: { type: Boolean, required: false, default: false },
        inputName: { type: String, required: true },
        error: { type: String, required: true }
    });

    const proxyChecked = computed({
        get() {
            return props.checked;
        },

        set(val: boolean) {
            emit('update:checked', val, props.value);
        },
    });
</script>

<template>
    <div class="flex grid-cols-2 gap-2 justify-between">
        <div class="flex items-center w-max">
            <Checkbox v-model="proxyChecked" binary :name="inputName" :input-id="inputName" :error="error"
                :value="value">
            </Checkbox>
        </div>
        <div class="w-full">
            <label :for="inputName" class="cursor-pointer">
                <slot></slot>
            </label>
        </div>
    </div>
</template>
