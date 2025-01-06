import { defineStore } from "pinia";
import axios from "axios";
const title = "category";
import Form from "vform";
import { appStore } from "./appStore";

export const categoryStore = defineStore(title, {
    state: () => ({
        title: title,
        route: "/api/category",
        listData: [],
        //👉 pass data with header data
        form: new Form({
            id: null,
            name: null,
            errors: [],
            isDialogVisible: false,
        }),
    }),
    actions: {
        // 👉 Fetch data
        async fetchData() {
            appStore().loading(true);
            await axios
                .get(this.route)
                .then((res: any) => {
                    if (res.data.success) {
                        this.listData = res.data.data.data;
                    }
                })
                .catch((err) => {
                    appStore().e_msg(err.message, err);
                })
                .finally(() => {
                    appStore().loading(false);
                });
        },

        // 👉 Create Or Update Data
        createOrUpdateData() {
            appStore().loading(true);
            const route =
                this.form.id == null
                    ? this.route
                    : `${this.route}/${this.form.id}`;
            const requestMethod = this.form.id == null ? "post" : "put";
            axios[requestMethod](route, this.form)
                .then((res: any) => {
                    if (res.data.success) {
                        appStore().s_msg(res.data.message);
                        if (this.form.id == null) {
                            this.listData.unshift(res.data.data);
                        } else {
                            const indexToUpdate = this.listData.findIndex(
                                (item: any) => item.id === this.form.id
                            );
                            if (indexToUpdate !== -1) {
                                this.listData.splice(
                                    indexToUpdate,
                                    1,
                                    res.data.data
                                );
                            }
                        }
                        this.form.errors = [];
                        this.form.reset();
                    } else {
                        this.form.errors = res.data.errors;
                        appStore().e_msg(res.data.message);
                    }
                })
                .catch((err) => {
                    appStore().e_msg(err.message, err);
                })
                .finally(() => {
                    appStore().loading(false);
                });
        },
        // 👉 Open modal form
        async openModal(data: any = null) {
            if (data !== null) {
                this.form.id = data.id;
                this.form.name = data.name;
            }
            // 👉 open to visible modal
            this.form.isDialogVisible = true;
        },
        // 👉 close modal form
        closeModal() {
            this.form.reset();
        },
        // 👉 Delete data
        async deleteData(id: number) {
            if (!confirm("Are You Sure To Delete !")) return;
            await axios
                .delete(`${this.route}/${id}`)
                .then((res: any) => {
                    if (res.data.success) {
                        const indexToRemove = this.listData.findIndex(
                            (item: any) => item.id == id
                        );
                        if (indexToRemove !== -1)
                            this.listData.splice(indexToRemove, 1);

                        appStore().s_msg(res.data.message);
                    } else {
                        appStore().w_msg(res.data.message);
                    }
                })
                .catch((error) => {
                    appStore().w_msg(error.message);
                })
                .finally();
        },
    },
});
