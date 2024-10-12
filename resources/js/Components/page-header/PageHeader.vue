<script setup lang="ts">
</script>
<template>
    <div class="flex flex-row justify-between items-center">
        <h1 class="pb-1 border-b-2 border-shark-950 dark:border-white-lilac-50 text-xl font-bold duration-500">
            <slot name="title"></slot>
        </h1>
        <slot name="action"></slot>
    </div>
</template>