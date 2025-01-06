<script setup lang="ts">
import { onMounted, ref } from "vue";
import { productStore } from "../../store/productStore";
import { Ref } from "vue";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";

// handle input File change
const handleFileUpload = (e: any) => {
    const file = e.target.files[0];
    productStore().form.image = file;
    productStore().form.filePreview = URL.createObjectURL(file);
};
</script>

<template>
    <TransitionRoot as="template" :show="productStore().form.isDialogVisible">
        <Dialog class="relative z-10" @close="productStore().form.reset()">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                        >
                            <div class="bg-white px-4 pb-4 pt-1 sm:p-6 sm:pb-4">
                                <div class="">
                                    <div
                                        class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"
                                    >
                                        <DialogTitle
                                            as="h3"
                                            class="text-base font-semibold text-center text-gray-900 capitalize"
                                            >{{
                                                productStore().form.id
                                                    ? "Edit"
                                                    : "New"
                                            }}
                                            {{
                                                productStore().title
                                            }}</DialogTitle
                                        >
                                        <form @submit.prevent="uploadFile">
                                            <div class="mt-2">
                                                <label
                                                    class="w-100 text-gray-700"
                                                    for=""
                                                    >Name
                                                    <span class="text-red-500"
                                                        >*
                                                        {{
                                                            productStore().form
                                                                .errors[
                                                                "name"
                                                            ]?.[0] || ""
                                                        }}
                                                    </span>
                                                </label>
                                                <div>
                                                    <input
                                                        type="text"
                                                        id="small-input"
                                                        v-model="
                                                            productStore().form
                                                                .name
                                                        "
                                                        placeholder="Name"
                                                        class="block w-full p-1 text-gray-900 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    />
                                                </div>

                                                <div class="my-3">
                                                    <label
                                                        class="w-100 text-gray-700"
                                                        for=""
                                                        >Price
                                                        <span
                                                            class="text-red-500"
                                                            >*
                                                            {{
                                                                productStore()
                                                                    .form
                                                                    .errors[
                                                                    "price"
                                                                ]?.[0] || ""
                                                            }}
                                                        </span>
                                                    </label>

                                                    <input
                                                        type="number"
                                                        step="0.1"
                                                        id="small-input"
                                                        v-model="
                                                            productStore().form
                                                                .price
                                                        "
                                                        placeholder="Price"
                                                        class="block w-full p-1 text-gray-900 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    />
                                                </div>
                                                <div class="my-3">
                                                    <label
                                                        class="w-100 text-gray-700"
                                                        for=""
                                                        >Image
                                                        <span
                                                            class="text-red-500"
                                                            >*
                                                            {{
                                                                productStore()
                                                                    .form
                                                                    .errors[
                                                                    "image"
                                                                ]?.[0] || ""
                                                            }}
                                                        </span>
                                                    </label>

                                                    <input
                                                        type="file"
                                                        @change="
                                                            handleFileUpload
                                                        "
                                                        accept="png,jpeg,gif,jpeg"
                                                        class="block w-full p-1 text-gray-900 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    />

                                                    <div
                                                        v-if="productStore().form.filePreview"
                                                        class="flex justify-center items-center mt-4"
                                                    >
                                                        <img
                                                            :src="productStore().form.filePreview"
                                                            alt="File Preview"
                                                            class="rounded-lg shadow-lg max-w-full max-h-96 object-contain"
                                                        />
                                                    </div>
                                                </div>

                                                <div class="mt-3">
                                                    <label
                                                        class="w-100 pt-3 text-gray-700"
                                                        for=""
                                                        >Categories
                                                        <span
                                                            class="text-red-500"
                                                        >
                                                            *{{
                                                                productStore()
                                                                    .form
                                                                    .errors[
                                                                    "categories"
                                                                ]?.[0] || ""
                                                            }}
                                                        </span></label
                                                    >
                                                    <select
                                                        v-model="
                                                            productStore().form
                                                                .categories
                                                        "
                                                        multiple
                                                        placeholder="Select Parent
                                                    Category"
                                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pl-3 pr-7 text-base text-gray-500 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm"
                                                    >
                                                        <!-- Placeholder option for instructions -->
                                                        <option
                                                            value=""
                                                            disabled
                                                            selected
                                                        >
                                                            Select Category
                                                        </option>

                                                        <!-- Loop through the category list -->
                                                        <option
                                                            v-for="(
                                                                item, index
                                                            ) in productStore()
                                                                .categoryList"
                                                            :key="index"
                                                            :value="item.id"
                                                        >
                                                            {{ item.name }}
                                                            <!-- Display category name -->
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                            >
                                <button
                                    type="button"
                                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                    @click="productStore().form.reset()"
                                >
                                    Close
                                </button>
                                <button
                                    type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-green-200 sm:mt-0 sm:w-auto"
                                    @click="productStore().createOrUpdateData()"
                                    ref="cancelButtonRef"
                                >
                                    Save
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
