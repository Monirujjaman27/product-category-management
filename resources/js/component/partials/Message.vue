<!-- Script to toggle toast visibility -->
<script setup lang="ts">
import { appStore } from "../../store/appStore";
</script>

<template>
    <!-- Toast container -->
    <div
        id="toast"
        class="fixed top-5 right-5 z-50 flex items-center p-4 space-x-4 text-white rounded-lg shadow-lg opacity-0 pointer-events-none transition-all duration-300"
        :class="
            appStore().color == 'success'
                ? 'bg-green-500'
                : appStore().color == 'error'
                ? 'bg-red-500'
                : 'bg-yellow-500'
        "
    >
        <div class="flex-shrink-0">
            <!-- Icon for the toast (optional) -->
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m2 2h-8m2 2h6m4 0a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
        </div>
        <div class="text-sm font-medium">{{ appStore().msg }}</div>
        <button class="ml-4 text-white hover:text-gray-200 focus:outline-none">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>
    </div>
</template>
<!-- Toast Style -->
<style>
.show-toast {
    opacity: 1;
    pointer-events: auto;
}
</style>
