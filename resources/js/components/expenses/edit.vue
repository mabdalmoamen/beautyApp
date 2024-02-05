<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form
                    @keydown.enter.prevent
                    enctype="multipart/form-data"
                    @submit.prevent="update"
                >
                <div
                        class="card-header">
                    <div
                        class="card-header  d-flex  align-items-center justify-content-between"
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
                              {{ __('Edit Expense Information') }}
                        </h6>
                        <button class="btn btn-primary" type="submit">
                            {{__('Save')}}
                        </button>
                    </div>
                    </div>
                    <div class="card-body text-center">
                        <img
                            v-if="newphoto"
                            :src="form.newphoto"
                            class="card-img-top w-25 h-25 m-auto"
                        />
                        <img
                            v-else=""
                            :src="form.expense_icon"
                            class="card-img-top w-25 h-25 m-auto"
                        />

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
                                class="form-control"
                                v-model="form.expense_title"
                                type="text"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">{{
                                    __("Mount")
                                }}</span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.expense_cost"
                                min="0"
                                type="number"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">{{
                                    __("Date")
                                }}</span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.expense_date"
                                type="date"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">{{
                                    __("Vat")
                                }}</span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.expense_vat"
                                type="number"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">{{
                                    __("Pay Method")
                                }}</span>
                            </div>
                            <select
                                id="inputState"
                                v-model="form.paid_Type"
                                class="form-control-sm text-center"
                            >
                                <option
                                    v-for="(pay, index) in payMethods"
                                    :key="index"
                                    :value="pay.id"
                                >
                                    {{ pay.pay_method_name }}
                                </option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <input
                                id="customFile"
                                class="custom-file-input"
                                type="file"
                                @change="onFileSelected"
                            />
                            <span
                                class="custom-file-label input-group-text w-100"
                                for="customFile"
                                style="width: 80px; text-align: center"
                            ></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "/" });
        }
        let id = this.$route.params.id;
        await axios
            .get("/api/expenses/" + id)
            .then(({ data }) => (this.form = data))
            .catch((error) => console.log(error));
        await this.allPayMethods();
    },

    data() {
        return {
            form: {
                expense_title: null,
                expense_cost: null,
                expense_icon: null,
                expense_date: null,
                newphoto: "",
            },
            newphoto: null,

            errors: {},
            payMethods: [],
        };
    },

    methods: {
        async allPayMethods() {
            await axios
                .get("/api/payMethods")
                .then(({ data }) => (this.payMethods = data))
                .catch((error) => console.log(error));
        },
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                Notification.image_validation();
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.newphoto = event.target.result;
                    this.newphoto = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        update() {
            let id = this.$route.params.id;
            this.form.user_id = localStorage.getItem("user_id");

            axios
                .patch("/api/expenses/" + id, this.form)
                .then(() => {
                    this.$router.push({ name: "expenses" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>

<style type="text/css"></style>
