<script setup lang="ts">
    import { Head } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import ContentGroup from '../../Components/elements/ContentGroup.vue';
    import PageHeader from '../../Components/page-header/PageHeader.vue';
    import CreatorDefaultContentLayout from '../../Layouts/ContentLayouts/CreatorDefaultContentLayout.vue';

    const isCopied = ref(false)

    function copyToClipboard(event: Event) {
        let element = event.target as HTMLElement
        let target = element.getAttribute('data-target')
        if (!target) {
            target = element.parentElement!.getAttribute('data-target')
        }
        navigator.clipboard.writeText(document.getElementById(target!)!.innerText)
        isCopied.value = true
        setTimeout(() => {
            isCopied.value = false
        }, 1000)
    }
</script>

<template>

    <Head title="Dashboard" />

    <CreatorDefaultContentLayout>
        <PageHeader class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</PageHeader>

        <div class="">You're logged in, {{ $page.props.auth.user.username
            }}!</div>
        <ContentGroup #content>{{ $page.props.auth.user.email }} - verified at: {{
            $page.props.auth.user.email_verified_at ?? 'not verified!'
        }}:</ContentGroup>
        <ContentGroup v-if="false" #content>
            <button @click="copyToClipboard($event)" data-target="token" class="relative"><i
                    class="fa fa-clipboard text-xl" :class="{ 'text-fern-500': isCopied }"></i>
                <div v-if="isCopied"
                    class="absolute top-full left-2/4 -translate-x-2/4 mt-1 border border-shark-500 bg-shark-200 p-2 before:content-[''] before:absolute before:-top-1 before:left-2/4 before:w-2 before:h-2 before:-translate-x-2/4 before:border-t before:border-l before:rotate-45 before:border-shark-500 before:bg-shark-200">
                    Copied!
                </div>
            </button>
            <pre id="token"></pre>
        </ContentGroup>
    </CreatorDefaultContentLayout>
</template>
