<script lang="ts" setup>
import { useRoute } from "vue-router";

const route = useRoute();
// Define props
const props = defineProps<{
    products: any[] | null; // Accepts an array or null
}>();

// format_number
const format_number = (val: any) => {
    if (val) {
        let val2 = parseFloat(val);
        return val2.toLocaleString("en-IN");
    } else {
        return 0;
    }
};
</script>

<template>
    <div
        class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
    >
        <a
            v-for="product in props.products"
            :key="product.id"
            :href="product.href"
            class="group bg-white p-4 rounded"
        >
            <img
                :src="product.image"
                :alt="product.image"
                class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]"
            />

            <h3 class="mt-4 text-sm text-center text-gray-700">
                {{ product.name }}
            </h3>
            <p class="mt-1 text-lg font-medium text-center text-gray-900">
                {{ format_number(product.price) }} ৳
            </p>
            <h3 class="mt-1 text-sm text-center text-gray-700">
                <span
                    v-for="(category, index) in product.categories"
                    :key="index"
                >
                    <span
                        class="inline-flex items-center justify-center px-3 mr-2 mb-2 text-sm font-medium text-white bg-indigo-600 rounded"
                    >
                        {{ category.name }}
                    </span>
                </span>
            </h3>
            <div v-if="route.path === '/product'" class="text-center">
                <button
                    @click="productStore().openModal(product)"
                    class="rounded-full bg-blue-500 text-white py-1 px-6 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                >
                    Edit
                </button>
                <button
                    @click="productStore().deleteData(product.id)"
                    class="rounded-full bg-red-500 text-white py-1 px-6 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                >
                    Delete
                </button>
            </div>
        </a>
    </div>
</template>
