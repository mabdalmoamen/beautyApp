<template>
    <div>
        {{ mixins.mixins_background }}
        <!-- Login Content -->
        <img :src="mixins.mixins_background ?mixins.mixins_background :'images/bg.jpg'" loading="lazy" class="bg" />
        <div v-if="!loading" class="container-login">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="card-body" style="width: 100%">
                            <div
                                class="card"
                                style="width: 400px; margin: 100px auto"
                            >
                                <div class="card-header">
                                    <h1 class="h2 text-success text-center">
                                        {{ __("Login") }}
                                    </h1>
                                </div>
                                <div class="logo text-center">
                                    <img src="backend/img/Gusto.jpeg" />
                                </div>
                                <div class="login-form text-center px-5 w-100">
                                    <form
                                        class="user w-100"
                                        @submit.prevent="login"
                                    >
                                        <div class="form-group">
                                            <label>{{ __("User Name") }}</label>
                                            <input
                                                required
                                                type="text"
                                                class="form-control"
                                                aria-describedby="emailHelp"
                                                :placeholder="__('User Name')"
                                                v-model="form.name"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __("Password") }}</label>

                                            <input
                                                required
                                                type="password"
                                                class="form-control"
                                                :placeholder="__('Password')"
                                                v-model="form.password"
                                            />
                                        </div>

                                        <div class="form-group">
                                            <button
                                                type="submit"
                                                class="btn btn-success border-5"
                                            >
                                                {{ __("Login") }}
                                            </button>
                                        </div>
                                        <small
                                            class="mb-2 alert-sm alert alert-danger"
                                            v-if="errors"
                                            >{{ errors }}</small
                                        >
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Content -->
    </div>
</template>

<script>
export default {
   async created() {
        if (User.loggedIn()) {
            this.$router.push("home");
        }
        await axios
            .get("/api/mixins/" + 1)
            .then(({ data }) => {
                this.mixins = data;
            })
    },
    data() {
        return {
            title: "Login",
            form: {
                name: "",
                password: "",
            },
            loading: false,
            user:{},
            mixins:{},
            errors: null,
        };
    },
    methods: {
        async login() {
            this.errors = null;
            await axios
                .post("api/auth/login", this.form)
                .then(async (response) => {
                    User.responseAfterLogin(response);
                    if (response.data.user.is_user != parseInt(100)) {
                        await this.$router.push({ name: "home" });
                    } else {
                        await this.$router.push({ name: "codies" });
                    }
                    location.reload();
                    await Notification.successMsg("تم تسجيل الدخول بنجاح");
                })
                .then((log) => {
                    this.loading = false;
                    let token = localStorage.getItem("token");
                    if (token) {
                        $("nav").css("display", "");
                        $("aside").css("display", "");
                        $(".layout-fixed").addClass("sidebar-mini");
                        $(".userName").text(localStorage.getItem("user"));
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    this.errors = error.response.data.error;

                    Notification.errorMsg(
                        error.response.data.error ?? error.response.data.message
                    );
                });
        },
    },
};
</script>
<style scoped>
.card img {
    -o-object-fit: cover;
    object-fit: cover;
    min-width: 120px;
    min-height: 120px;
    border-radius: 50%;
    transition: filter 0.3s ease;
}
.card img:hover {
    filter: grayscale(0) contrast(100%);
}
.container-login {
    position: relative;
    z-index: 999;
    height: 85vh;
}
.bg {
    /* background: url("/images/bg.jpg"); */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    height: 100%;
    width: 100%;
    z-index: 1;
}
</style>
