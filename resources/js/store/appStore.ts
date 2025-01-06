import moment from "moment";
import { defineStore } from "pinia";
import Form from "vform";
const api_based_url = "http://127.0.0.1:8000/";
export const appStore = defineStore("app", {
    state: () => ({
        demo_null_img: "default_img",
        assets_path: api_based_url,
        API_BASE_URL: api_based_url + "api/",
        msg: "",
        isSnackbarVisible: true,
        position: "",
        color: "",
        loader: false,
        is_login: true,
    }),
    actions: {
        loading(is_loading: boolean) {
            this.loader = is_loading;
        },
        //return success message
        async s_msg(msg: string, position: string = "top end") {
            this.isSnackbarVisible = true;
            this.color = "success";
            this.msg = msg;
            this.position = position;
            await this.showToast();
        },

        //error msg
        async e_msg(
            msg: string,
            err: any = null,
            position: string = "top end"
        ) {
            if (err !== null && err.response && err.response.status == 401) {
                this.is_login = false;
            }
            this.isSnackbarVisible = true;
            this.color = "error";
            this.msg = msg;
            this.position = position;
            await this.showToast();
        },
        //error msg
        async w_msg(
            msg: string,
            err: any = null,
            position: string = "top end"
        ) {
            this.isSnackbarVisible = true;
            this.color = "warning";
            this.msg = msg;
            this.position = position;
            await this.showToast();
        },
        // showToast
        async showToast() {
            const toast = await document.getElementById("toast");
            if (toast) {
                toast.classList.add("show-toast");
                setTimeout(() => {
                    toast.classList.remove("show-toast");
                }, 3000); // Auto-hide after 3 seconds
            }
        },
        // format Date and time
        formatDate(date: string) {
            return moment(date).format("DD-MM-Y H:M A");
        },
    },
    // Check Permission
});
