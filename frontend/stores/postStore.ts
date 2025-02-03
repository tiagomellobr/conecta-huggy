import { defineStore } from "pinia";
import axios from "axios";

export const usePostStore = defineStore("post", {
    state: () => ({
        posts: [],
        post: null,
        loading: true,
        error: null,
    }),
    actions: {
        async fetchPosts() {
            const config = useRuntimeConfig();
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get(
                    `${config.public.apiBaseUrl}posts`
                );
                this.posts = response.data;
            } catch (error) {
                this.error = "Erro ao buscar posts";
            } finally {
                this.loading = false;
            }
        },
        async fetchPost(id: number) {
            const config = useRuntimeConfig();
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get(
                    `${config.public.apiBaseUrl}posts/${id}`
                );
                this.post = response.data;
            } catch (error) {
                this.error = "Erro ao buscar post";
            } finally {
                this.loading = false;
            }
        },
    },
});

export interface Post {
    id: number;
    title: string;
    content: string;
    likes_count: number;
    comments_count: number;
    user: any;
}
