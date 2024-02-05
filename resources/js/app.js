require("./bootstrap");

require("lang.js");

import Vue from "vue";
import VueRouter from "vue-router";
import VueHtmlToPaper from "vue-html-to-paper";
import sidebar from "./components/layout/sidebar.vue";
import topbar from "./components/layout/topbar.vue";
import types from "./components/types/index.vue";
import { routes } from "./routes";
//Multi lang
import { Lang } from "laravel-vue-lang";
import Cookie from "./Helpers/Cookie";
import Auth from "./Helpers/Auth";
import VueQuagga from "vue-quaggajs";

// import the styles
// Vue.config.productionTip = false;

import datePicker from "./components/date/index";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
Vue.use(datePicker);

window.Cookie = Cookie;
window.Auth = Auth;

Vue.use(Lang, {
    locale: localStorage.getItem("lang"),
    fallback: "ar",
});

// register component 'v-quagga'
Vue.use(VueQuagga);

Vue.use(VueRouter);
let normalize =
    "https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css";

let bootstrap =
    window.location.origin + "/backend/vendor/bootstrap/css/bootstrap.rtl.css";
let style = window.location.origin + "/css/print.css";
Vue.use(VueRouter);
window.Fire = new Vue();

const options = {
    name: "_blank",
    specs: [
        "fullscreen=yes",
        "height=400",
        "width=600",
        "titlebar=yes",
        "scrollbars=yes",
    ],
    styles: [normalize, style],
    timeout: 1000,
    autoClose: true,
};
Vue.use(VueHtmlToPaper, options);

// Import User Class
import User from "./Helpers/User";

window.User = User;
//Notification
import Notification from "./Helpers/Notification";
import JsPrintApp from "./Helpers/JsPrint";
import axios from "axios";
window.JsPrintApp = JsPrintApp;

window.Notification = Notification;
//end sweet alert
const router = new VueRouter({
    routes,
    mode: "history", // short for `routes: routes`
});
router.beforeEach(async(to, from, next) => {
    if (!to.meta.roleName || to.name == "home") {
        next();
    } else {
        let role = await axios.get("/api/checkHaveRole/" + to.meta.roleName);
        if (role.data == 0) {
            if (localStorage.getItem("token")) {
                Notification.navigationAlert();
            } else {
                next((name = "/"));
            }
        } else {
            next();
        }
    }
});
window.Reload = new Vue();

const app = new Vue({
    components: {
        sidebar,
        topbar,
        types,
    },
    async created() {
        if (User.loggedIn()) {
            this.user = await Auth.getAuth();
            this.mixins = this.user.branch;
            this.codies = this.user.branch;
            $("nav").css("display", "");
            $("aside").css("display", "");
            $(".layout-fixed").addClass("sidebar-mini");
            $(".userName").text(this.user.name);
            $(".gustoTitle").text(this.mixins.mixin_name);
        }
        this.mixins.default_lang = localStorage.getItem("lang");
        this.codies.default_lang = localStorage.getItem("lang");
        this.lang = localStorage.getItem("lang");
    },
    data() {
        return {
            userRoles: [],
            roles: [],
            mixins: {},
            codies: {},
            user: {},
            lang: "ar",
        };
    },
    // render: (h) => h(App),

    el: "#app",
    router,
});
