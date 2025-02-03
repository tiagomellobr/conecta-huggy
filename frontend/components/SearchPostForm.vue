<template>
    <div>
        <form @submit.prevent="searchPosts" class="flex items-center space-x-2 mb-4">
            <input type="text" v-model="searchQuery" placeholder="Search posts" class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 flex-grow" />
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Search</button>
        </form>
    </div>
</template>

<script setup lang="ts">
const postStore = usePostStore();
const searchQuery = ref('');

const searchPosts = async () => {
    await postStore.fetchPosts();
    postStore.posts = postStore.posts.filter(post => 
        post.title.includes(searchQuery.value) || 
        post.content.includes(searchQuery.value)
    );
};
</script>