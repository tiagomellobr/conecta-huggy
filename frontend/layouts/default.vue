<template>
    <div class="flex flex-col min-h-screen">
        <div class="container mx-auto max-w-3xl flex-grow">
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
        <Footer />
    </div>
</template>

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
</style>

<script setup>
    const config = useRuntimeConfig();
    let huggyScript = '';

    if (config.public.env === 'production') {
        huggyScript = "var $_Huggy = { defaultCountry: '+55', uuid: '5741a2cd-8d98-4fb6-b598-767d8c7c13d1' , company: '359123' }; (function(i,s,o,g,r,a,m){ i[r]={context:{id:'3c2b78346489fcd071c5fb12bf393aab'}};a=o;o=s.createElement(o); o.async=1;o.src=g;m=s.getElementsByTagName(a)[0];m.parentNode.insertBefore(o,m); })(window,document,'script','https://js.huggy.chat/widget.min.js','pwz');";
    }
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
        script: [
            {
                children: huggyScript,
            }
        ]
    });
</script>