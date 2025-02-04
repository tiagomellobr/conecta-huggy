<template>
    <nav class="font-mono">
        <ul class="flex space-x-4 items-center">
            <li><NuxtLink to="/" class="p1 hover:text-gray-500 dark:hover:text-gray-300">Forum</NuxtLink></li>
            <li><NuxtLink to="/videos" class="p1 hover:text-gray-500 dark:hover:text-gray-300">Videos</NuxtLink></li>
            <li><NuxtLink to="/news" class="p1 hover:text-gray-500 dark:hover:text-gray-300">News</NuxtLink></li>
        
            <li v-if="!userStore.user"><NuxtLink to="/register" class="p1 hover:text-gray-500 dark:hover:text-gray-300">Register</NuxtLink></li>
            <li v-if="!userStore.user"><NuxtLink to="/login" class="p1 hover:text-gray-500 dark:hover:text-gray-300">Login</NuxtLink></li>
            <li><ColorModeSelector /></li>
            <li v-if="userStore.user" class="p1">
                <img :src="`https://placehold.co/40x40?text=${userStore.user.name.charAt(0)}`" alt="User Avatar" class="rounded-full w-8 h-8 inline-block">
                {{ userStore.user.name }}
            </li>
            <li v-if="userStore.user">
                <button @click="logout" class="p1 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-6 h-6 text-gray-800 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"></path>
                    </svg>
                </button>
            </li>
        </ul>
    </nav>
</template>

<script setup lang="ts">
import { useUserStore } from '@/stores/userStore';
const userStore = useUserStore();

const logout = () => {
    userStore.logout();
};
</script>