<template>
    <div>
        <div v-if="postStore.loading" class="text-center dark:text-gray-300">Carregando...</div>
        <div v-if="postStore.error" class="text-red-500 text-center dark:text-red-300">{{ postStore.error }}</div>
        <div v-if="postStore.post" class="grid grid-cols-1 gap-5">
            <h2 class="text-xl font-semibold mb-2 dark:text-gray-100">{{ postStore.post.title }}</h2>
            <p class="text-gray-700 dark:text-gray-100">{{ postStore.post.content }}</p>
            <div class="flex justify-between items-center mt-4">
            <div class="text-gray-600 dark:text-gray-200">
                <span>{{ postStore.post.likes_count }} Likes</span> | 
                <span>{{ postStore.post.comments_count }} Comments</span>
            </div>
            <div class="text-gray-500 dark:text-gray-200">
                Posted by {{ postStore.post.user.name }}
            </div>
            </div>
            <hr class="dark:border-gray-600">
            <!-- <div class="mt-6">
            <h2 class="text-lg font-semibold mb-3 uppercase dark:text-gray-300">Comments</h2>
            <ul>
                <li v-for="(comment, index) in commentsList" :key="index" class="shadow-md p-4 rounded-sm bg-white mb-2 dark:bg-gray-800">
                <div class="text-gray-800 font-semibold dark:text-gray-300">{{ comment.user }}</div>
                <div class="text-gray-600 border-l-4 border-gray-300 pl-2 dark:text-gray-400 dark:border-gray-600"> {{ comment.content }}</div>
                </li>
            </ul>
            </div> -->
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePostStore } from '~/stores/postStore';
import { useRoute } from 'vue-router';

const route = useRoute();
const postStore = usePostStore();

onMounted(async () => {
    await postStore.fetchPost(route.params.id);

    const { post } = postStore;
    
    useSeoMeta({
        title: post.title,
        ogTitle: post.title,
        twitterTitle: post.title,
        twitterCard: 'summary',
    });
});

</script>