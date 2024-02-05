<template>
    <div class="container-login">
        <div class="row justify-content-center" >
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-form text-center">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">
                                {{ __("استعادة كلمة المرور") }}
                            </h1>
                            <p class="mb-4">يجب كتابة الايميل الخاص بالمستخدم لارسال كلمة المرور عليه</p>

                        </div>
                    </div>
                <form class="user p-5"  @submit.prevent="sendResetPasswordLink">

                <!-- Login -->
                    <div class="form-group">
                        <input
                            type="email"
                            class="form-control"
                            aria-describedby="emailHelp"
                            placeholder="Enter email"
                            v-model="form.email"
                            required
                        />


                    </div>
                <button type="submit" class="btn btn-block btn-primary" >
                    Reset Password
                </button>
            </form>
            </div>
            </div>
                    </div>
                </div>  </div>
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

    },
    data() {
        return {
            title:"login",
            form: {
                email: null,
                password: null,
            },
            loading: false,
            errors: {},
        };
    },
    methods: {
        async sendResetPasswordLink() {
            await axios.post('api/auth/reset-password-request', this.form).then((d)=>console.log(d)).catch(err=>console.log(err))
        },

    },
};
</script>
