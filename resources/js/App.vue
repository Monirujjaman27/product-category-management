<script setup lang="ts">
import HeaderComponent from "./component/partials/HeaderComponent.vue";
</script>

<template>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
            alt="Laravel background"
        />
        <div
            class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <HeaderComponent />

                <main class="mt-6">
                    <router-view></router-view>
                </main>

                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                ></footer>
            </div>
        </div>
    </div>
</template>
