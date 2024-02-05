<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form
                    @keydown.enter.prevent
                    @submit.prevent="create"
                    enctype="multipart/form-data"
                >
                    <div class="card-header">
                        <div
                            class="d-flex align-items-center justify-content-between"
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
                                {{ __("Insert Unit Information") }}
                            </h6>
                            <button class="btn btn-primary" type="submit">
                                {{ __("Save") }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span
                                    id="basic-addon1"
                                    class="input-group-text"
                                    >{{ __("Unit Name Ar") }}</span
                                >
                            </div>
                            <input
                                required
                                aria-describedby="basic-addon1"
                                class="form-control"
                                v-model="form.unit_ar_name"
                                type="text"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{
                                    __("Unit Name En")
                                }}</span>
                            </div>
                            <input
                                aria-describedby="basic-addon1"
                                class="form-control"
                                v-model="form.unit_en_name"
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
        this.user = await Auth.getAuth();
        this.form.branch_id = this.user.branch_id;
    },
    data() {
        return {
            title: "Create Unit",
            form: {
                unit_ar_name: null,
                unit_en_name: null,
            },
            errors: {},
        };
    },

    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                Notification.image_validation();
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.expense_icon = event.target.result;
                    console.log(event.target.result);
                };
                reader.readAsDataURL(file);
            }
        },
        create() {
            axios
                .post("/api/mainunits", this.form)
                .then(() => {
                    this.$router.push({ name: "units" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>
