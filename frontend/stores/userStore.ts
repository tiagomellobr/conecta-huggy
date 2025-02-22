import { defineStore } from "pinia";
import axios from "axios";

export const useUserStore = defineStore("userStore", {
    state: () => ({
        user: null,
        token: null,
        errorEmail: null,
        errorPassword: null,
        errorName: null,
    }),
    persist: piniaPluginPersistedstate.cookies(),
    actions: {
        async login(email: string, password: string) {
            const config = useRuntimeConfig();
            try {
                const response = await axios.post(
                    `${config.public.apiBaseUrl}login`,
                    {
                        email,
                        password,
                    }
                );
                this.token = response.data.token;
                sessionStorage.setItem("token", this.token);
                await this.fetchUser();
            } catch (error: any) {
                const errorData = error.response.data;
                this.errorEmail = Array.isArray(errorData.email)
                    ? errorData.email.join(";")
                    : errorData.email;
                this.errorPassword = Array.isArray(errorData.password)
                    ? errorData.password.join(";")
                    : errorData.password;

                if (errorData.message) {
                    this.errorPassword = errorData.message;
                }
            }
        },
        async logout() {
            const config = useRuntimeConfig();
            try {
                await axios.post(
                    `${config.public.apiBaseUrl}logout`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                this.token = null;
                this.user = null;
                sessionStorage.removeItem("token");
            } catch (error) {
                this.token = null;
                this.user = null;
                console.error("Erro ao fazer logout:", error);
            }
        },
        async fetchUser() {
            const config = useRuntimeConfig();
            try {
                const response = await axios.get(
                    `${config.public.apiBaseUrl}user`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                this.user = response.data;
            } catch (error) {
                console.error("Erro ao buscar informações do usuário:", error);
            }
        },
        async register(name: string,  email: string, password: string, passwordConfirmation: string) {
            const config = useRuntimeConfig();

            if (password !== passwordConfirmation) {
                this.errorPassword = "As senhas não conferem";
                return;
            }

            try {
                const response = await axios.post(
                    `${config.public.apiBaseUrl}register`,
                    {
                        name,
                        email,
                        password,
                    }
                );
                this.token = response.data.token;
                sessionStorage.setItem("token", this.token);
                await this.fetchUser();
            } catch (error: any) {
                console.log(error);
                
                const errorData = await error.response.data;
                this.errorName = Array.isArray(errorData.name)
                    ? errorData.name.join(";")
                    : errorData.name;
                this.errorEmail = Array.isArray(errorData.email)
                    ? errorData.email.join(";")
                    : errorData.email;
                this.errorPassword = Array.isArray(errorData.password)
                    ? errorData.password.join(";")
                    : errorData.password;

                if (errorData.message) {
                    this.errorPassword = errorData.message;
                }
            }
        }
    },
});
