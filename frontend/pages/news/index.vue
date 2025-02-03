<template>
    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
            <div v-for="news in newsList" :key="news.id" class="bg-white p-4 rounded-lg shadow-md">
                <NuxtLink :to="`/news/${news.id}`">
                    <h3 class="text-xl font-semibold mb-2">{{ news.title }}</h3>
                    <p class="text-gray-700 mb-4">{{ news.content }}</p>
                </NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
        newsList: [
        { id: 1, title: 'Notícia 1', content: 'Conteúdo da notícia 1' },
        { id: 2, title: 'Notícia 2', content: 'Conteúdo da notícia 2' },
        { id: 3, title: 'Notícia 3', content: 'Conteúdo da notícia 3' },
        { id: 4, title: 'Notícia 4', content: 'Conteúdo da notícia 4' },
        { id: 5, title: 'Notícia 5', content: 'Conteúdo da notícia 5' },
    ]};
  },
};
</script>

<script setup>
    useSeoMeta({
        title: 'News Page',
        description: 'This is the news page',
        keywords: 'news, page, nuxt, vue, js',
        url: 'https://www.huggy.io/',
        ogTitle: 'News Page',
        ogDescription: 'This is the news page',
        ogUrl: 'https://www.huggy.io/',
        twitterTitle: 'News Page',
        twitterDescription: 'This is the news page',
        twitterUrl: 'https://www.huggy.io/',
        twitterCard: 'summary',
    });
</script>