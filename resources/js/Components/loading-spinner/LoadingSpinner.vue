<template>
    <div class="relative min-h-40">
        <div class="loading absolute top-2/4 left-2/4">
            <div
                class="spinner absolute top-10 left-2/4 h-20 w-20 border-[1rem] border-dashed rounded-full border-woodsmoke-950 dark:border-timberwolf-50">
            </div>
            <div class="mt-24">
                <slot>Loading</slot>...
            </div>
        </div>
    </div>
</template>