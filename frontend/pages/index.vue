<template>
    <div class="grid grid-cols-1 gap-5">
        <div v-for="post in posts" :key="post.id" class="bg-white p-4 rounded-sm shadow-md">
            <NuxtLink :to="`/post/${post.id}`">
                <h3 class="text-xl font-semibold mb-2">{{ post.title }}</h3>
                <p class="text-gray-700">{{ post.content }}</p>
                <div class="flex justify-between items-center mt-4">
                    <div class="text-gray-600">
                        <span>{{ post.likes }} Likes</span> | 
                        <span>{{ post.comments }} Comments</span>
                    </div>
                    <div class="text-gray-500">
                        Posted by {{ post.user }}
                    </div>
                </div>
            </NuxtLink>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
    posts: [
      { id: 1, title: 'Post 1', content: 'Conteúdo do post 1', likes: 10, comments: 2, user: 'User1' },
      { id: 2, title: 'Post 2', content: 'Conteúdo do post 2', likes: 20, comments: 4, user: 'User2' },
      { id: 3, title: 'Post 3', content: 'Conteúdo do post 3', likes: 30, comments: 6, user: 'User3' },
      { id: 4, title: 'Post 4', content: 'Conteúdo do post 4', likes: 40, comments: 8, user: 'User4' },
      { id: 5, title: 'Post 5', content: 'Conteúdo do post 5', likes: 50, comments: 10, user: 'User5' },
      ],
    };
  },
};
</script>

<script setup>
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