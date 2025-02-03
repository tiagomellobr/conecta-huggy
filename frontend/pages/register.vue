<template>
    <div class="container mx-auto p-4 max-w-md">
        <h1 class="text-3xl font-bold mb-6">Registro</h1>
        <form @submit.prevent="register">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nome:</label>
                <input type="text" v-model="name" id="name" class="w-full p-2 border border-gray-300 rounded-md" required />
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" v-model="email" id="email" class="w-full p-2 border border-gray-300 rounded-md" required />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Senha:</label>
                <input type="password" v-model="password" id="password" class="w-full p-2 border border-gray-300 rounded-md" required />
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirme a Senha:</label>
                <input type="password" v-model="password_confirmation" id="password_confirmation" class="w-full p-2 border border-gray-300 rounded-md" required />
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md">Registrar</button>
        </form>
        <p class="mt-4 text-center">
            Já tem uma conta? <NuxtLink to="/login" class="text-blue-500">Faça login</NuxtLink>
        </p>
  </div>
</template>

<script setup>
const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');

const register = async () => {};
</script>