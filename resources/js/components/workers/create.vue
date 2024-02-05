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
                                {{ __("Insert  Worker Information") }}
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
                                >
                                    {{ __("Worker Name") }}</span
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
                                <span
                                    id="basic-addon2"
                                    class="input-group-text"
                                >
                                    {{ __("Mobile") }}</span
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
                                <span
                                    id="basic-addon2"
                                    class="input-group-text"
                                >
                                    {{ __("commission") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.commission"
                                type="number"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="is_percent_commission"
                                    v-model="form.is_percent_commission"
                                />
                                <label
                                    class="custom-control-label"
                                    for="is_percent_commission"
                                    > {{ __('is_percent_commission') }}</label
                                >
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __("Salary") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.salary"
                                type="text"
                            />
                        </div>
                        <div class="input-group mb-3">
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
                                    {{ __("Work Hour") }}</span
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
                                    {{ __("Work Hour") }}</span
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
            this.$router.push("/");
        }
        let user = await Auth.getAuth();
        this.form.branch_id = user.branch_id;
        await this.generateBarcode();
    },
    data() {
        return {
            form: {
                name: "",
                mobile: "",
                work_hour_count: 8,
                hour_price: 0,
                jop_title: "",
                salary: 0,
                pin_code: "",
            },
            errors: {},
        };
    },

    methods: {
        generateBarcode() {
            this.form.pin_code = "";
            var val1 = Math.floor(2000000 + Math.random() * 999);
            this.form.pin_code = 2 + "" + val1;
        },
        create() {
            axios
                .post("/api/workers", this.form)
                .then(() => {
                    this.$router.push({ name: "workers" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>
