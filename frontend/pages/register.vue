<template>
    <div class="container mx-auto p-4 max-w-md">
        <h1 class="text-3xl font-bold mb-6">Registro</h1>
        <form @submit.prevent="register">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300">Nome:</label>
                <input type="text" v-model="name" id="name" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" required />
                <p v-if="nameError" class="text-red-500 mt-2">{{ nameError }}</p>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-gray-300">Email:</label>
                <input type="email" v-model="email" id="email" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" required />
                <p v-if="emailError" class="text-red-500 mt-2">{{ emailError }}</p>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 dark:text-gray-300">Senha:</label>
                <input type="password" v-model="password" id="password" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" required />
                <p v-if="passwordError" class="text-red-500 mt-2">{{ passwordError }}</p>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300">Confirme a Senha:</label>
                <input type="password" v-model="password_confirmation" id="password_confirmation" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" required />
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md dark:bg-blue-700">Registrar</button>
        </form>
        <p class="mt-4 text-center">
            Já tem uma conta? <NuxtLink to="/login" class="text-blue-500 dark:text-blue-300">Faça login</NuxtLink>
        </p>
    </div>
</template>

<script setup lang="ts">
const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const nameError = ref(null);
const passwordError = ref(null);
const emailError = ref(null);

const userStore = useUserStore();
const router = useRouter();

const register = async () => {
    
    await userStore.register(name.value, email.value, password.value, password_confirmation.value);

    nameError.value = userStore.errorName;
    passwordError.value = userStore.errorPassword;
    emailError.value = userStore.errorEmail;

    if (userStore.token) {
        nameError.value = null;
        passwordError.value = null;
        emailError.value = null;
        router.push('/');
    }
};

useSeoMeta({
    title: "Registro Page",
    description: "This is the registration page",
    keywords: "register, page, nuxt, vue, js",
    ogTitle: "Registro Page",
    ogDescription: "This is the registration page",
    twitterTitle: "Registro Page",
    twitterDescription: "This is the registration page",
    twitterCard: "summary",
});
</script>