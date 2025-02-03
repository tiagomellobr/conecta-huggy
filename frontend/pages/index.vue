<template>
    <div>
        <div v-if="loading" class="text-center">Carregando...</div>
        <div v-if="error" class="text-red-500 text-center">{{ error }}</div>
        <div v-if="!loading && !error" class="grid grid-cols-1 gap-5">
            <div v-for="post in posts" :key="post.id" class="bg-white p-4 rounded-sm shadow-md">
                <NuxtLink :to="`/post/${post.id}`">
                    <h3 class="text-xl font-semibold mb-2">{{ post.title }}</h3>
                    <p class="text-gray-700">{{ post.content }}</p>
                    <div class="flex justify-between items-center mt-4">
                        <div class="text-gray-600">
                            <span>{{ post.likes_count }} Likes</span> | 
                            <span>{{ post.comments_count }} Comments</span>
                        </div>
                        <div class="text-gray-500">
                            Posted by {{ post.user.name }}
                        </div>
                    </div>
                </NuxtLink>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePostStore, type Post } from '@/stores/postStore';

const postStore = usePostStore();

const { posts: Post, loading, error, fetchPosts } = postStore;

const posts: Post[] = postStore.posts;

await fetchPosts();

useSeoMeta({
    title: 'Home Page',
    description: 'This is the home page',
    keywords: 'home, page, nuxt, vue, js',
    url: 'https://www.huggy.io/',
    ogTitle: 'Home Page',
    ogDescription: 'This is the home page',
    ogUrl: 'https://www.huggy.io/',
    twitterTitle: 'Home Page',
    twitterDescription: 'This is the home page',
    twitterUrl: 'https://www.huggy.io/',
    twitterCard: 'summary',
});
</script>