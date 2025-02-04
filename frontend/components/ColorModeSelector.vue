<template>
    <div class="flex space-x-2 items-center">
        <button
            @click="toggleMode"
            @mouseenter="showNextModelLabel = true"
            @mouseleave="showNextModelLabel = false"
        >
            {{ nextModeIcon }}
        </button>
    </div>
</template>

<script setup>
const colorMode = useColorMode();
const modes = ["light", "dark", "system"];

const nextModeIcons = {
    system: "🌓",
    light: "🌕",
    dark: "🌑",
};

const nextMode = computed(() => {
    const currentModeIndex = modes.indexOf(colorMode.preference);
    let nextModeIndex = null;
    if (currentModeIndex + 1 === modes.length) {
        nextModeIndex = 0;
    } else {
        nextModeIndex = currentModeIndex + 1;
    }
    return modes[nextModeIndex];
});
const nextModeIcon = computed(() => nextModeIcons[nextMode.value]);

const toggleMode = () => (colorMode.preference = nextMode.value);
</script>