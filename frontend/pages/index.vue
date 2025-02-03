<template>
    <div>
        <SearchPostForm />
        <PostForm />
        <PostsList />
    </div>
</template>

<script setup lang="ts">
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