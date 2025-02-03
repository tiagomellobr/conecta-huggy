<template>
    <div class="container mx-auto max-w-3xl">
        <header class="flex justify-between items-center py-4 px-1 mt-5 mb-3 border-b border-gray-300">
            <div>
                <NuxtLink to="/" class="text-xl font-semibold hover:text-gray-500">Conecta Huggy</NuxtLink>
            </div>
            <Menu />
        </header>
        <main class="p-2">
            <slot />
        </main>
    </div>
</template>

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
</style>

<script setup>
    useHead({
        titleTemplate: '%s - Conecta Huggy',
        meta: [
            {
                charset: 'utf-8',
            },
            {
                name: 'viewport',
                content: 'width=device-width, initial-scale=1',
            },
        ],
        htmlAttrs: {
            lang: 'en',
        },
        link: [
            {
                rel: 'icon',
                type: 'image/x-icon',
                href: '/favicon.ico',
            },
            {
                rel: 'stylesheet',
                href: 'https://fonts.googleapis.com/css2?family=Roboto&display=swap',
            },
        ],
    });
</script>