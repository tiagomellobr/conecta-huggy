// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    compatibilityDate: "2024-11-01",
    devtools: { enabled: true },
    modules: [
        "@nuxtjs/tailwindcss",
        "@nuxtjs/color-mode",
        "@pinia/nuxt",
        "pinia-plugin-persistedstate/nuxt",
        "nuxt-gtag",
    ],
    buildModules: ["@nuxtjs/axios"],
    runtimeConfig: {
        public: {
            apiBaseUrl: process.env.API_BASE_URL,
        },
    },
    gtag: {
        enabled: process.env.NODE_ENV === "production",
        id: process.env.GOOGLE_ANALYTICS_ID,
    },
    colorMode: {
        classSuffix: "",
    }
});
