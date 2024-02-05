<template>
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="login-form text-center">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">
                                            {{ __("Change Password") }}
                                        </h1>
                                    </div>
                                </div>
                                <form class="user p-5" @submit.prevent="change">
                                    <div class="form-group">
                                        <label>البريد الالكتروني</label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            v-model="form.email"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>كلمة السر الجديدة</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            v-model="form.password"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label> اعادة كلمة السر الجديدة</label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            v-model="form.password_confirmation"
                                        />
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-block btn-primary"
                                    >
                                        حفظ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";
export default {
    components: { Spinner },
    created() {
        if (User.loggedIn()) {
            this.$router.push("home");
        }
        let uri = window.location.search.substring(1);
        let params = new URLSearchParams(uri);

        this.form.passwordToken = params.get("token");
        console.log("token" + this.$route.params);
        console.log(params.get("token"));
    },
    data() {
        return {
            title: "login",
            form: {
                email: null,
                password: null,
                password_confirmation: null,
                passwordToken: null,
            },
            loading: false,
            errors: {},
        };
    },
    methods: {
        async change() {
            await axios
                .post("api/auth/change-password", this.form)
                .then(async () => {
                    await this.$router.push({ name: "/" });
                })
                .catch((error) => {
                    this.errors = error.response.data.error;
                    Notification.errorMsg(
                        error.response.data.error ?? error.response.data.message
                    );
                });
        },
    },
};
</script>
