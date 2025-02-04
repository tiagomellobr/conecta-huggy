<template>
    <div>
        <footer class="bg-gray-800 text-white py-4 mt-8 w-full dark:bg-gray-800 dark:text-gray-300">
            <div class="container mx-auto text-center text-sm">
                <p>&copy; {{ year }} Conecta Huggy. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
    const year = new Date().getFullYear();
</script>