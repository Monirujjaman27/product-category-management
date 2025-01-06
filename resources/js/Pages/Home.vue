<!-- resources/js/Pages/product.vue -->
<script lang="ts" setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import ProductCard from "../component/ProductCard.vue";

const selectedCategories = ref(null);
const products = ref([]);
const categories = ref([]);
const fetchData = async () => {
    const response = await axios
        .get("api/get-product-categories")
        .then((res: any) => {
            console.log({ res });

            products.value = res.data.data.products.data; // assuming products is a key in the res
            categories.value = res.data.data.categories; // assuming categories is a key in the res
        });
};

onMounted(() => {
    fetchData();
});
</script>

<template>
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <h2
            class="text-2xl font-bold tracking-tight text-white text-center pb-10 uppercase"
        >
            Category & Products Management
        </h2>
        <h3 class="mt-1 mb-3 text-sm text-center text-gray-700">
            <span v-for="(category, index) in categories" :key="index">
                <span
                    class="inline-flex items-center justify-center px-3 mr-2 mb-2 text-sm font-medium text-white bg-indigo-600 rounded"
                >
                    {{ category.name }}
                </span>
            </span>
        </h3>
        <ProductCard :products="products" />
    </div>
</template>
