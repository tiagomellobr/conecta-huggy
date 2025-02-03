<template>
    <div class="grid grid-cols-1 gap-5">
        <h2 class="text-xl font-semibold mb-2">{{ post.title }}</h2>
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
        <hr>
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-3 uppercase">Comments</h2>
            <ul>
                <li v-for="(comment, index) in commentsList" :key="index" class="shadow-md p-4 rounded-sm bg-white mb-2">
                    <div class="text-gray-800 font-semibold">{{ comment.user }}</div>
                    <div class="text-gray-600 border-l-4 border-gray-300 pl-2"> {{ comment.content }}</div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
        post: { id: 1, title: 'Post 1', content: 'Conteúdo do post 1', likes: 10, comments: 2, user: 'User1' },
        commentsList: [
            { user: 'Commenter1', content: 'Great post!' },
            { user: 'Commenter2', content: 'Thanks for sharing!' }
        ]
    };
  },
};
</script>