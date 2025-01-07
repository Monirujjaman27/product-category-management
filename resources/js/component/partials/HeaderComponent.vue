<script setup lang="ts">
import Message from "./Message.vue";
</script>

<template>
    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
        <div class="flex justify-center">
            <div class="flex">
                <div
                    class="lg:flex lg:flex-1 items-center justify-center space-x-6"
                >
                    <router-link
                        to="/"
                        class="text-sm font-medium hover:text-green-800"
                        active-class="text-green-800"
                        >Home</router-link
                    >
                    <router-link
                        to="products"
                        class="text-sm font-medium hover:text-green-800"
                        active-class="text-green-800"
                        >Products</router-link
                    >
                    <router-link
                        to="categories"
                        class="text-sm font-medium hover:text-green-800"
                        active-class="text-green-800"
                        >Category</router-link
                    >
                </div>
            </div>
        </div>
        <Message />
    </header>
</template>
