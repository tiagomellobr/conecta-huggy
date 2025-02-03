<template>
    <div class="grid grid-cols-1 gap-5">
        <h2 class="text-xl font-semibold mb-2">{{ news.title }}</h2>
        <p class="text-gray-700">{{ news.content }}</p>
    </div>
</template>

<script>
export default {
  data() {
    return {
        news: { id: 1, title: 'Notícia 1', content: 'Conteúdo da notícia 1' }
    };
  },
};
</script>