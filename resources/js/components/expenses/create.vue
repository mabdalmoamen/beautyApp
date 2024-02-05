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
                                {{ __("Insert Expense Information") }}
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
                                v-model="form.vat"
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
                                v-model="form.paid"
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
                            <img
                                :src="form.expense_icon"
                                class="card-img-top w-25 h-25 float-left ml-auto"
                            />
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

<script>
export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.form.branch_id = this.user.branch_id;

        await this.allPayMethods();
    },
    data() {
        return {
            form: {
                expense_title: null,
                expense_cost: null,
                expense_icon: null,
                expense_date: null,
                user_id: null,
                vat: null,
                paid: null,
            },
            user: {},
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
                    this.form.expense_icon = event.target.result;
                    console.log(event.target.result);
                };
                reader.readAsDataURL(file);
            }
        },
        create() {
            this.form.user_id = localStorage.getItem("user_id");

            axios
                .post("/api/expenses", this.form)
                .then(() => {
                    this.$router.push({ name: "expenses" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>
