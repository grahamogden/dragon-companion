<script setup lang="ts"></script>
<template>
    <div class="mb-6 px-4">
        <h3 class="mb-2">
            <slot name="heading"></slot>
        </h3>
        <div>
            <slot name="content"></slot>
        </div>
    </div>
</template>