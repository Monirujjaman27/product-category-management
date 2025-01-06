<!-- resources/js/Pages/Categories.vue -->

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { categoryStore } from "../../store/categoryStore";
import CreateOrUpdate from "./createOrUpdate.vue";
import { appStore } from "../../store/appStore";

const fetchData = async () => {
    await categoryStore().fetchData();
    console.log(categoryStore().listData);
};
onMounted(fetchData);
</script>

<template>
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <h2
            class="text-2xl font-bold tracking-tight text-white text-center pb-10 uppercase"
        >
            Categories
        </h2>
        <CreateOrUpdate v-if="categoryStore().form.isDialogVisible" />
        <p class="text-end">
            <button
                @click.prevent="categoryStore().openModal()"
                class="rounded bg-blue-500 text-white py-1 px-6 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
            >
                New Category
            </button>
        </p>
        <ul role="list" class="divide-y divide-gray-100">
            <li
                v-for="item in categoryStore().listData"
                :key="item.id"
                class="bg-white my-2 px-5 rounded flex justify-between gap-x-6 py-5"
            >
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm/6 font-semibold text-gray-900">
                            {{ item.name }}
                        </p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="mt-1 text-xs/5 text-gray-500">
                        <span class="me-3">
                            Created Date
                            <time :datetime="item.created_at">{{
                                appStore().formatDate(item?.created_at)
                            }}</time>
                        </span>
                        <button
                            @click="categoryStore().openModal(item)"
                            class="rounded-full bg-blue-500 text-white py-1 px-4 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        >
                            Edit
                        </button>
                        <button
                            @click="categoryStore().deleteData(item.id)"
                            class="rounded-full bg-red-500 text-white py-1 px-4 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        >
                            Delete
                        </button>
                    </p>
                </div>
            </li>
        </ul>
    </div>
</template>
