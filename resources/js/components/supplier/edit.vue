<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
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
                                {{ __("Edit Supplier Information") }}
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
                                v-model="form.supplier_name"
                                aria-describedby="basic-addon1"
                                class="form-control"
                                type="text"
                                required
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"
                                    >{{ __("Mobile") }}
                                </span>
                            </div>
                            <input
                                v-model="form.supplier_mobile"
                                aria-describedby="basic-addon2"
                                class="form-control"
                                type="text"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __("Total Withdrawals") }}
                                </span>
                            </div>
                            <input
                                v-model="form.supplier_total_withdrawals"
                                aria-describedby="basic-addon2"
                                class="form-control"
                                readonly
                                type="number"
                                step="0.01"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    {{ __("Total Paid") }}
                                </span>
                            </div>
                            <input
                                v-model="form.supplier_total_paid"
                                aria-describedby="basic-addon2"
                                class="form-control"
                                readonly
                                type="number"
                                step="0.01"
                            />
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{
                                    __("Total Remain")
                                }}</span>
                            </div>
                            <input
                                v-model="form.supplier_total_remain"
                                aria-describedby="basic-addon1"
                                class="form-control"
                                readonly
                                type="number"
                                step="0.01"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                 <div
                    class="card-header">
                <div
                    class="d-flex align-items-center bg-secondary justify-content-between"
                >
                    <h6 class="m-0 font-weight-bold text-primary">
                         {{ __('Pay For Supplier') }}
                    </h6>
                    <button
                        class="btn btn-primary"
                        type="button"
                        @click="pay(form)"
                    >
                        {{__('Pay')}}
                    </button>
                </div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ __('Total Remain') }}</span>
                        </div>
                        <input
                            v-model="form.supplier_total_remain"
                            aria-describedby="basic-addon1"
                            class="form-control"
                            readonly
                            type="text"
                        />
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">{{__('Mount')}}</span>
                        </div>
                        <input
                            v-model="supplier_pay"
                            aria-describedby="basic-addon2"
                            class="form-control"
                            type="number"
                            step="0.01"
                        />
                    </div>
                </div>
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
            .get("/api/suppliers/" + id)
            .then(({ data }) => (this.form = data))
            .catch((err) => console.log(err));
    },

    data() {
        return {
            form: {
                supplier_name: "",
                supplier_mobile: "",
            },
            supplier_pay: "",
            errors: {},
        };
    },

    methods: {
        pay(supplier) {
            if (supplier.supplier_total_remain > 0) {
                if (this.supplier_pay > 0) {
                    axios
                        .get(
                            "/api/supplierPay/" +
                                supplier.supplier_id +
                                "/" +
                                this.supplier_pay
                        )
                        .then(() => {
                            this.$router.push({ name: "suppliers" });
                            Notification.success();
                        })
                        .catch(
                            (error) =>
                                (this.errors = error.response.data.errors)
                        );
                } else {
                    Notification.customMsg(
                        "error",
                        "topRight",
                        "يرجى كتابة مبلغ اكبر من 0"
                    );
                }
            } else {
                Notification.customMsg(
                    "warning",
                    "topRight",
                    "تم دفع حساب المورد بالكامل"
                );
            }
        },
        update() {
            let id = this.$route.params.id;
            axios
                .patch("/api/suppliers/" + id, this.form)
                .then(() => {
                    this.$router.push({ name: "suppliers" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>

<style type="text/css">
.input-group-text {
    min-width: 160px;
}
</style>
