<template>
    <div v-if="userStore.token">
        <div class="flex justify-end">
            <button
            @click="showForm = !showForm" 
            :class="!showForm ? 'bg-blue-500 hover:bg-blue-700' : 'bg-red-500 hover:bg-red-700'"
            class="text-white font-bold py-2 px-2 rounded-full mb-4"
            >
                <svg v-if="!showForm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <svg v-if="showForm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form v-if="showForm" @submit.prevent="createPost" class="space-y-4 p-4 bg-white shadow-md rounded-md mb-4">
            <div class="flex flex-col">
                <label for="title" class="mb-2 font-semibold text-gray-700">Title:</label>
                <input type="text" id="title" v-model="newPost.title" required class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="flex flex-col">
                <label for="content" class="mb-2 font-semibold text-gray-700">Content:</label>
                <textarea id="content" v-model="newPost.content" required class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Create New Post</button>
        </form>
    </div>
</template>
<script setup lang="ts">
const userStore = useUserStore();
const postStore = usePostStore();
const newPost = ref({ title: '', content: '' });
const showForm = ref(false);

const createPost = async () => {
    await postStore.createPost(newPost.value);
    newPost.value = { title: '', content: '' };
    postStore.fetchPosts();
    showForm.value = false;
};
</script>