<template>
    <!-- Modal -->
    <div
        class="modal fade"
        id="withdrawModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        >
                            <h6 class="m-0 font-weight-bold text-primary">
                                صرف نقدية
                            </h6>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="withdraw">
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                >القيمة
                                            </span>
                                        </div>
                                        <input
                                            aria-describedby="basic-addon1"
                                            aria-label="القيمة"
                                            class="form-control"
                                            v-model="form.pay"
                                            placeholder="القيمة"
                                            type="text"
                                        />
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                >طريقة الدفع:</span
                                            >
                                        </div>
                                        <select
                                            id="inputState"
                                            v-model="form.pay_method"
                                            class="form-control form-control text-center"
                                        >
                                            <option
                                                :class="
                                                    pay.id == 3 ? 'd-none' : ''
                                                "
                                                v-for="(
                                                    pay, index
                                                ) in payMethods"
                                                :value="pay.id"
                                                :key="index"
                                            >
                                                {{ pay.pay_method_name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"
                                                >كود العميل</span
                                            >
                                        </div>
                                        <input
                                            aria-describedby="basic-addon2"
                                            aria-label="كود العميل-هاتف العميل"
                                            class="form-control"
                                            placeholder="كود العميل-هاتف العميل"
                                            @keyup="findCustomer"
                                            v-model="cust_id"
                                            type="text"
                                        />

                                        <a
                                            class="btn btn-info btn text-light"
                                            @click="
                                                showWithdraw = !showWithdraw
                                            "
                                            ><i
                                                class="fas fa-search font-weight-bold text-light"
                                            ></i
                                        ></a>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"
                                                >اسم العميل</span
                                            >
                                        </div>
                                        <input
                                            aria-describedby="basic-addon2"
                                            aria-label="اسم العميل"
                                            class="form-control"
                                            readonly
                                            placeholder="اسم العميل"
                                            @keyup="findCustomer"
                                            v-model="form.customer.cust_name"
                                            type="text"
                                        />
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"
                                                >رصيد العميل</span
                                            >
                                        </div>
                                        <input
                                            aria-describedby="basic-addon2"
                                            aria-label="رصيد العميل"
                                            class="form-control"
                                            readonly
                                            placeholder="رصيد العميل"
                                            @keyup="findCustomer"
                                            v-model="form.customer.cust_balance"
                                            type="text"
                                        />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div
                        id="exampleModal"
                        aria-hidden="true"
                        aria-labelledby="exampleModalLabel"
                        :class="
                            showWithdraw
                                ? 'modal fade d-block show'
                                : 'modal fade'
                        "
                        role="dialog"
                        tabindex="-1"
                    >
                        <div
                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document"
                        >
                            <div class="modal-content m-auto">
                                <div class="modal-body">
                                    <div class="col-lg-12 mb-4">
                                        <div class="table-responsive">
                                            <table
                                                class="table align-items-center"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="col-header"
                                                            style="width: 10%"
                                                        >
                                                            كود العميل
                                                        </th>
                                                        <th
                                                            class="col-header"
                                                            style="width: 20%"
                                                        >
                                                            اسم العميل
                                                        </th>
                                                        <th
                                                            class="col-header"
                                                            style="width: 10%"
                                                        >
                                                            هاتف العميل
                                                        </th>
                                                        <th
                                                            class="col-header"
                                                            style="width: 10%"
                                                        >
                                                            تحديد
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(
                                                            customer, index
                                                        ) in customers"
                                                        :key="index"
                                                    >
                                                        <td>
                                                            {{
                                                                customer.cust_id
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                customer.cust_name
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                customer.cust_mobile
                                                            }}
                                                        </td>
                                                        <td>
                                                            <button
                                                                class="btn btn-success btn-sm"
                                                                @click="
                                                                    selectCustomer(
                                                                        customer
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    class="fa fa-plus font-weight-bold text-light"
                                                                ></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        class="btn btn-secondary"
                                        @click="showWithdraw = !showWithdraw"
                                        type="button"
                                    >
                                        إغلاق
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        data-dismiss="modal"
                    >
                        إغلاق
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="withdraw()"
                    >
                        حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["customers"],
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }

        await this.allPayMethods();
    },
    name: "withdraw",
    data() {
        return {
            showWithdraw: false,
            cust_id: "",
            payMethods: [],

            form: {
                is_pay: false,
                customer: {},
                pay: 0,
                pay_method: 1,
                user_id: localStorage.getItem("user_id"),
            },
        };
    },
    methods: {
        async allPayMethods() {
            await axios
                .get("/api/payMethods")
                .then(({ data }) => (this.payMethods = data))
                .catch((error) => console.log(error));
        },
        selectCustomer(customer) {
            this.form.customer = customer;
            this.cust_id = customer.cust_id;

            this.showWithdraw = false;
        },
        async findCustomer() {
            await axios
                .get("/api/customers/" + this.cust_id)
                .then(({ data }) => {
                    this.form.customer = data;
                })
                .catch((error) => console.log(error));
        },

        withdraw() {
            axios
                .post("/api/customerPay", this.form)
                .then(() => {
                    this.$router.push({ name: "cash" });
                    Notification.success();
                    this.showWithdraw = false;
                    this.form.customer = {};
                    this.form.pay = "";
                })
                .catch((error) => {
                    Notification.error();
                });
        },
    },
};
</script>

<style scoped></style>
