<!-- resources/js/Pages/product.vue -->
<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { productStore } from "../../store/productStore";
import CreateOrUpdate from "./createOrUpdate.vue";
import ProductCard from "../../component/ProductCard.vue";
const fetchData = async () => {
    await productStore().fetchData();
};
onMounted(fetchData);
</script>

<template>
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <h2
            class="text-2xl font-bold tracking-tight text-white text-center pb-10 uppercase"
        >
            Product
        </h2>
        <CreateOrUpdate v-if="productStore().form.isDialogVisible" />
        <p class="text-center mb-4">
            <button
                @click.prevent="productStore().openModal()"
                class="rounded bg-blue-500 text-white py-1 px-6 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
            >
                New Product
            </button>
        </p>
        <ProductCard :products="productStore().listData" />
    </div>
</template>
