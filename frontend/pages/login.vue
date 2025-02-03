<template>
    <div class="container mx-auto p-4 max-w-md">
        <h1 class="text-3xl text-center font-bold mb-6">Login</h1>
        <form @submit.prevent="handleLogin">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" v-model="email" id="email" class="w-full p-2 border border-gray-300 rounded-md" required />
                <p v-if="userStore.errorEmail" class="text-red-500 mt-2">{{ userStore.errorEmail }}</p>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Senha:</label>
                <input type="password" v-model="password" id="password" class="w-full p-2 border border-gray-300 rounded-md" required />
                <p v-if="userStore.errorPassword" class="text-red-500 mt-2">{{ userStore.errorPassword }}</p>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md">Login</button>
        </form>
        <p class="mt-4 text-center">
            Não tem uma conta? <NuxtLink to="/register" class="text-blue-500">Registre-se</NuxtLink>
        </p>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/userStore';

const email = ref('');
const password = ref('');
const router = useRouter();
const userStore = useUserStore();

const handleLogin = async () => {
  await userStore.login(email.value, password.value);
  if (userStore.token) {
    router.push('/');
  }
  
};
</script>
