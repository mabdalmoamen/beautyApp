<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form @keydown.enter.prevent @submit.prevent="create">
                    <div
                        class="card-header">
                    <div
                        class=" d-flex  align-items-center justify-content-between"
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
                           {{ __('Insert Stock') }}
                        </h6>
                        <button class="btn btn-primary" type="submit">
                            {{__('Save')}}
                        </button>
                    </div>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span id="basic-addon1" class="input-group-text"
                                    >{{__('Stock Name')}}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon1"
                                class="form-control"
                                v-model="form.title"
                                type="text"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span id="basic-addon2" class="input-group-text"
                                    >{{__('Stock')}}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.stock"
                                type="text"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span id="basic-addon2" class="input-group-text"
                                    >{{__('Cost')}}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.type_price"
                                type="number"
                                min="0"
                                step="0.01"
                                required
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
            form: {
                title: null,
                stock: null,
            },
            errors: {},
        };
    },

    methods: {
        create() {
            axios
                .post("/api/stocks", this.form)
                .then(() => {
                    this.$router.push({ name: "stocks" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors))
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .then((e) => {
                    if (this.errors.title)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.title[0]
                        );
                    if (this.errors.stock)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.stock[0]
                        );
                });
        },
    },
};
</script>
