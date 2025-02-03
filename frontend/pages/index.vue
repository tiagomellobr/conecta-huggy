<template>
    <div>
        <div v-if="postStore.loading" class="text-center">Carregando...</div>
        <div v-if="postStore.error" class="text-red-500 text-center">{{ postStore.error }}</div>
        <div v-if="!postStore.loading && !postStore.error" class="grid grid-cols-1 gap-5">
            <div v-for="post in postStore.posts" :key="post.id" class="bg-white p-4 rounded-sm shadow-md">
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

<script lang="ts">
export default defineComponent({
    setup() {
        const postStore = usePostStore();

        return {
            postStore
        };
    },

    async mounted() {
        await this.postStore.fetchPosts();
    },
});

useSeoMeta({
    title: 'Home Page',
    description: 'This is the home page',
    keywords: 'home, page, nuxt, vue, js',
    ogTitle: 'Home Page',
    ogDescription: 'This is the home page',
    twitterTitle: 'Home Page',
    twitterDescription: 'This is the home page',
    twitterCard: 'summary',
});
</script>