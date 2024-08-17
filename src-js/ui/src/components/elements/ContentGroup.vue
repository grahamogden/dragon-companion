<script setup lang="ts"></script>
<template>
    <div class="mb-6">
        <h3 v-if="$slots.heading"
            class="mb-2 font-bold border-b border-woodsmoke-700/50 dark:border-timberwolf-50/50 transition-colors duration-theme-change">
            <slot name="heading"></slot>
        </h3>
        <div>
            <slot name="content"></slot>
        </div>
    </div>
</template>