<script setup>
import { onMounted, ref } from "vue";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { categoryStore } from "../../store/categoryStore";
</script>

<template>
    <TransitionRoot as="template" :show="categoryStore().form.isDialogVisible">
        <Dialog class="relative z-10" @close="categoryStore().form.reset()">
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
                                            class="text-center font-semibold text-gray-900 capitalize"
                                            >{{
                                                categoryStore().form.id
                                                    ? "Edit"
                                                    : "New"
                                            }}
                                            {{
                                                categoryStore().title
                                            }}</DialogTitle
                                        >
                                        <div class="mt-2">
                                            <label
                                                class="w-100 text-gray-700"
                                                for=""
                                                >Name
                                                <span class="text-red-500"
                                                    >*
                                                    {{
                                                        categoryStore().form
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
                                                        categoryStore().form
                                                            .name
                                                    "
                                                    placeholder="Category Name"
                                                    class="block w-full p-1 text-gray-900 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:px-6">
                                <div class="sm:px-4">
                                    <button
                                        type="button"
                                        class="mt-3 inline-flex justify-center rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-green-200 sm:mt-0 sm:w-auto"
                                        @click="
                                            categoryStore().createOrUpdateData()
                                        "
                                        ref="cancelButtonRef"
                                    >
                                        Save
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                        @click="categoryStore().form.reset()"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
