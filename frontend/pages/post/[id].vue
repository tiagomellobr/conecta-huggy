<template>
    <div>
        <div v-if="postStore.loading" class="text-center">Carregando...</div>
        <div v-if="postStore.error" class="text-red-500 text-center">{{ postStore.error }}</div>
        <div v-if="postStore.post" class="grid grid-cols-1 gap-5">
            <h2 class="text-xl font-semibold mb-2">{{ postStore.post.title }}</h2>
            <p class="text-gray-700">{{ postStore.post.content }}</p>
            <div class="flex justify-between items-center mt-4">
                <div class="text-gray-600">
                    <span>{{ postStore.post.likes_count }} Likes</span> | 
                    <span>{{ postStore.post.comments_count }} Comments</span>
                </div>
                <div class="text-gray-500">
                    Posted by {{ postStore.post.user.name }}
                </div>
            </div>
            <hr>
            <!-- <div class="mt-6">
                <h2 class="text-lg font-semibold mb-3 uppercase">Comments</h2>
                <ul>
                    <li v-for="(comment, index) in commentsList" :key="index" class="shadow-md p-4 rounded-sm bg-white mb-2">
                        <div class="text-gray-800 font-semibold">{{ comment.user }}</div>
                        <div class="text-gray-600 border-l-4 border-gray-300 pl-2"> {{ comment.content }}</div>
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