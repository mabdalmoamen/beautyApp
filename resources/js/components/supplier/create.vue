<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form @keydown.enter.prevent @submit.prevent="create">
                    <div class="card-header">
                        <div
                            class="d-flex align-items-center justify-content-between"
                        >
                            <a
                                class="btn btn-warning text-light"
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
                                {{ __("Insert Supplier Information") }}
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
                                    {{ __("Supplier Name") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon1"
                                class="form-control"
                                v-model="form.supplier_name"
                                type="text"
                                required
                            />
                            <small
                                class="text-danger errorMsg d-none"
                                v-if="errors.supplier_name"
                            >
                                {{ errors.supplier_name[0] }}
                            </small>
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
                                v-model="form.supplier_mobile"
                                type="text"
                            />
                            <small
                                class="text-danger errorMsg d-none"
                                v-if="errors.supplier_mobile"
                            >
                                {{ errors.supplier_mobile[0] }}
                            </small>
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
        this.user = await Auth.getAuth();
        this.form.branch_id = this.user.branch_id;
    },
    data() {
        return {
            form: {
                supplier_name: null,
                supplier_mobile: null,
            },
            errors: {},
        };
    },

    methods: {
        async create() {
            axios
                .post("/api/suppliers", this.form)
                .then(() => {
                    this.$router.push({ name: "suppliers" });
                    Notification.success();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .then((e) => {
                    if (this.errors.supplier_name)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.supplier_name[0]
                        );
                    if (this.errors.supplier_mobile)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.supplier_mobile[0]
                        );
                });
        },
    },
};
</script>
