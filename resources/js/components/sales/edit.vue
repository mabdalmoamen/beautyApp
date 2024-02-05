<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form @keydown.enter.prevent @submit.prevent="update">
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
                                {{ __("Edit Sale Type") }}
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
                                    >{{ __("Title") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon1"
                                :aria-label="__('Title')"
                                class="form-control"
                                v-model="form.sill_type_name"
                                :placeholder="__('Title')"
                                type="text"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span
                                    id="basic-addon1"
                                    class="input-group-text"
                                >
                                    {{ __("Cost") }}</span
                                >
                            </div>
                            <input
                                aria-describedby="basic-addon1"
                                :aria-label="__('Cost')"
                                class="form-control"
                                v-model="form.cost"
                                :placeholder="__('Cost')"
                                type="text"
                                required
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "/" });
        }
        let id = this.$route.params.id;
        axios
            .get("/api/saleType/" + id)
            .then(({ data }) => (this.form = data))
            .catch((err) => console.log(err));
    },

    data() {
        return {
            form: {
                cost: "",
                sill_type_name: "",
            },
            errors: {},
        };
    },

    methods: {
        generateBarcode() {
            this.form.pin_code = "";
            var val1 = Math.floor(2000000 + Math.random() * 999);
            this.form.pin_code = 2 + this.form.id + val1;
        },
        update() {
            let id = this.$route.params.id;
            axios
                .patch("/api/saleType/" + id, this.form)
                .then(() => {
                    this.$router.push({ name: "sales" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>

<style type="text/css"></style>
