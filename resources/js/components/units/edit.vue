<template>
    <div>
        <div class="modal-body">
            <div
                v-if="$root.$data.user.edit_unit"
                class="row justify-content-center"
            >
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <form @keydown.enter.prevent
                            enctype="multipart/form-data"
                            @submit.prevent="update"
                        >
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
                                        v-model="unit.unit_ar_name"
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
                                        v-model="unit.unit_en_name"
                                        type="text"
                                    />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button
                id="close"
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
            >
                {{ __("Close") }}
            </button>
            <button class="btn btn-primary" @click="update()" type="submit">
                {{ __("Save") }}
            </button>
        </div>
    </div>
</template>

<script type="text/javascript">

export default {
    props: ["unit"],

    async created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "/" });
        }

    },

    data() {
        return {
            title: "Edit",
            form: {
                unit_ar_name: null,
                unit_en_name: null,
            },

            errors: {},
        };
    },

    methods: {
        update() {
            axios
                .patch("/api/mainunits/" + this.unit.unit_id, this.unit)
                .then(() => {
                    // this.$router.push({ name: "units" });
                    Notification.success();
                    $("#close").click();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>

<style type="text/css"></style>
