<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="video in videos" :key="video.id" class="bg-white dark:bg-gray-800 p-1 rounded-lg shadow-md">
            <iframe
                :src="video.url"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                class="w-full h-48"
            ></iframe>
            <h3 class="text-xl font-semibold my-2 p-2 text-gray-900 dark:text-gray-100">{{ video.title }}</h3>
            <p class="text-gray-700 dark:text-gray-300 p-2">{{ video.description }}</p>
        </div>
    </div>
</template>
<script>
export default {
  data() {
    return {
        videos: [
            { id: 1, title: 'Vídeo 1', description: 'Descrição do vídeo 1', url: 'https://www.youtube.com/embed/dQw4w9WgXcQ' },
            { id: 2, title: 'Vídeo 2', description: 'Descrição do vídeo 2', url: 'https://www.youtube.com/embed/dQw4w9WgXcQ' },
            { id: 3, title: 'Vídeo 3', description: 'Descrição do vídeo 3', url: 'https://www.youtube.com/embed/dQw4w9WgXcQ' },
            { id: 4, title: 'Vídeo 4', description: 'Descrição do vídeo 4', url: 'https://www.youtube.com/embed/dQw4w9WgXcQ' },
            { id: 5, title: 'Vídeo 5', description: 'Descrição do vídeo 5', url: 'https://www.youtube.com/embed/dQw4w9WgXcQ' },
        ],
    };
  },
};
</script>

<script setup>
    useSeoMeta({
        title: 'Videos Page',
        description: 'This is the videos page',
        keywords: 'videos, page',
        url: 'https://www.huggy.io/',
        ogTitle: 'Video Page',
        ogDescription: 'This is the videos page',
        ogUrl: 'https://www.huggy.io/',
        twitterTitle: 'Videos Page',
        twitterDescription: 'This is the videos page',
        twitterUrl: 'https://www.huggy.io/',
        twitterCard: 'summary',
    });
</script>