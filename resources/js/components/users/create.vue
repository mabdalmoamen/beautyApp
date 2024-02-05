<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form @keydown.enter.prevent @submit.prevent="create">
                    <div class="card-header">
                        <div
                            class="d-flex flex-row align-items-center justify-content-between"
                        >
                            <a
                                class="btn btn-warning text-light float-right"
                                @click="$router.go(-1)"
                            >
                                <i
                                    :class="
                                        $root.$data.codies.default_lang == 'ar'
                                            ? 'fa fa-arrow-right'
                                            : 'fa fa-arrow-left'
                                    "
                                ></i>
                            </a>
                            <h6 class="m-0 font-weight-bold text-primary">
                                {{ __("Insert User Information") }}
                            </h6>
                            <button class="btn btn-primary" type="submit">
                                {{ __("Save") }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span
                                    id="basic-addon1"
                                    class="input-group-text"
                                    >{{ __("User Name") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon1"
                                class="form-control"
                                v-model="form.name"
                                type="text"
                                required
                            />
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __("Passowrd") }}
                                </span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.password"
                                type="text"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="bill_type"
                                    v-model="form.is_admin"
                                />
                                <label
                                    class="custom-control-label"
                                    for="bill_type"
                                >
                                    {{ __("is_admin") }}</label
                                >
                            </div>
                        </div>
                        <div class="input-group mb-3 d-none">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    {{ __("Barcode") }}
                                    <button
                                        type="button"
                                        class="btn"
                                        @click="generateBarcode"
                                    >
                                        <i class="fa fa-sync"></i></button
                                ></span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.pin_code"
                                type="text"
                            />
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span
                                    id="basic-addon2"
                                    class="input-group-text"
                                >
                                    {{ __("Branch_id") }}</span
                                >
                            </div>
                            <select
                                v-model="form.branch_id"
                                class="form-select form-control"
                            >
                                <option
                                    v-for="(branch, index) in branches"
                                    :key="index"
                                    :value="branch.id"
                                >
                                    {{ branch.mixins_name }}
                                </option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span
                                    id="basic-addon2"
                                    class="input-group-text"
                                    >{{ __("Mobile") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.mobile"
                                type="text"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">{{
                                    __("Salary")
                                }}</span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.salary"
                                type="text"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __("Jop") }}
                                </span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.jop_title"
                                type="text"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __("Work hour") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.work_hour_count"
                                type="text"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __("Work hour Price") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.hour_price"
                                type="text"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    async created() {
        if (!User.loggedIn()) {
            Notification.navigationAlert();
            this.$router.push("/");
        }
        await this.generateBarcode();
        this.allBranches();
    },
    data() {
        return {
            form: {
                name: "",
                mobile: "",
                work_hour_count: 8,
                password: "",
                hour_price: 0,
                jop_title: "",
                salary: 0,
                email: "",
                is_admin: false,
                pin_code: "",
            },
            errors: {},
            branches: {},
        };
    },

    methods: {
        allBranches() {
            axios
                .get("/api/mixins")
                .then(({ data }) => {
                    this.loading = false;
                    this.branches = data;
                })
                .catch((error) => console.log(error));
        },
        generateBarcode() {
            this.form.pin_code = "";
            var val1 = Math.floor(1000000 + Math.random() * 999);
            this.form.pin_code = 1 + "" + val1;
        },

        create() {
            axios
                .post("/api/users", this.form)
                .then(() => {
                    this.$router.push({ name: "users" });
                    Notification.success();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .then((e) => {
                    if (this.errors.name)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.name[0]
                        );
                    if (this.errors.password)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.password[0]
                        );
                });
        },
    },
};
</script>
