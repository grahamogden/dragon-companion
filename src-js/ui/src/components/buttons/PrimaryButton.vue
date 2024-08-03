<template>
    <div
        class="inline-block w-full md:w-auto bg-saffron-mango-300 dark:bg-saffron-mango-800 border border-saffron-mango-600 dark:border-saffron-mango-300 rounded-lg overflow-hidden">
        <button
            class="relative w-full min-w-48 md:w-auto py-2 px-4 text-woodsmoke-950 dark:text-timberwolf-50 hover:text-timberwolf-50 dark:hover:text-woodsmoke-950 hover:bg-saffron-mango-600 dark:hover:bg-saffron-mango-300 text-center no-underline"
            type="submit">
            <slot>Submit</slot>
        </button>
    </div>
</template>