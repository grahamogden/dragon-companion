<script setup lang="ts"></script>
<template>
    <div class="">
        <h3 v-if="$slots.heading" class="mb-2 font-bold">
            <slot name="heading"></slot>
        </h3>
        <div
            class="pl-2 border-l border-woodsmoke-700/50 dark:border-timberwolf-50/50 transition-colors duration-theme-change">
            <slot name="content"></slot>
        </div>
    </div>
</template>