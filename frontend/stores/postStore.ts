import { defineStore } from "pinia";
import { useUserStore } from "@/stores/userStore";
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
        async createPost(newPost: { title: string; content: string }) {
            const config = useRuntimeConfig();
            this.loading = true;
            this.error = null;
            const userStore = useUserStore();
            const token = userStore.token;

            try {
                await axios.post(`${config.public.apiBaseUrl}posts`, newPost, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
            } catch (error) {
                this.error = "Erro ao criar post";
            } finally {
                this.loading = false;
            }
        },
        async likePost(id: number) {
            const config = useRuntimeConfig();
            this.loading = true;
            this.error = null;
            const userStore = useUserStore();
            const token = userStore.token;

            try {
                await axios.post(
                    `${config.public.apiBaseUrl}posts/${id}/likes`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                await this.fetchPost(id);
                await this.fetchPosts();
            } catch (error) {
                this.error = "Already liked";
            } finally {
                this.loading = false;
            }
        },
        async removeLikePost(id: number) {
            const config = useRuntimeConfig();
            this.loading = true;
            this.error = null;
            const userStore = useUserStore();
            const token = userStore.token;

            try {
                await axios.delete(
                    `${config.public.apiBaseUrl}posts/${id}/likes`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                await this.fetchPost(id);
                await this.fetchPosts();
            } catch (error) {
                this.error = error.message.data.message;
            } finally {
                this.loading = false;
            }
        }
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
