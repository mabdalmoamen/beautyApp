<template>
    <div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a
                    class="nav-link active"
                    id="home-tab"
                    data-toggle="tab"
                    href="#pay"
                    role="tab"
                    aria-controls="home"
                    aria-selected="true"
                    >توريد</a
                >
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    id="profile-tab"
                    data-toggle="tab"
                    href="#withdraw"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                    >صرف</a
                >
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div
                class="tab-pane fade show active"
                id="pay"
                role="tabpanel1"
                aria-labelledby="pay-tab"
            >
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive w-100">
                            <table
                                class="table align-items-center"
                                v-if="customersPay.length > 0"
                            >
                                <thead>
                                    <tr>
                                        <th style="width: 10%">
                                            {{ __("Document No") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("total") }}
                                        </th>
                                        <th style="width: 10%">التاريخ</th>
                                        <th style="width: 10%">اسم العميل</th>
                                        <th style="width: 10%">اسم المستخدم</th>
                                        <th style="width: 10%">
                                            رصيد العميل قبل
                                        </th>
                                        <th style="width: 10%">
                                            رصيد العميل بعد
                                        </th>
                                        <th style="width: 10%">طريقة الدفع</th>

                                        <th style="width: 10%">ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(pay, index) in customersPay"
                                        :key="index"
                                    >
                                        <td>{{ pay.customer_cash_id }}</td>
                                        <td>{{ pay.paid_value }}</td>
                                        <td>{{ pay.paid_date }}</td>
                                        <td>
                                            {{ pay.customer.cust_name }}
                                        </td>
                                        <td>{{ pay.user.name }}</td>
                                        <td>
                                            {{ pay.cust_balance_before }}
                                        </td>
                                        <td>{{ pay.cust_after_after }}</td>
                                        <td>
                                            {{
                                                pay.pay_methods.pay_method_name
                                            }}
                                        </td>

                                        <td>{{ pay.note }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p v-else class="text-center">
                                {{ __("No Data Yet") }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer text-center text-light mb-2">
                        <a
                            class="btn btn-success"
                            data-toggle="modal"
                            data-target="#payModal"
                            >إضافة</a
                        >
                        <router-link to="/bill" class="btn btn-danger"
                            >إغلاق</router-link
                        >
                    </div>
                </div>
                <Pay :customers="customers"></Pay>
            </div>
            <div
                class="tab-pane"
                id="withdraw"
                role="tabpanel2"
                aria-labelledby="withdraw-tab"
            >
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive w-100">
                            <table
                                v-if="cuatomersWithdrawals.length > 0"
                                class="table align-items-center sortTable"
                            >
                                <thead>
                                    <tr>
                                        <th style="width: 10%">رقم المستند</th>
                                        <th style="width: 10%">المبلغ</th>
                                        <th style="width: 10%">التاريخ</th>
                                        <th style="width: 10%">اسم العميل</th>
                                        <th style="width: 10%">اسم المستخدم</th>
                                        <th style="width: 10%">
                                            رصيد العميل قبل
                                        </th>
                                        <th style="width: 10%">
                                            رصيد العميل بعد
                                        </th>
                                        <th style="width: 10%">طريقة الدفع</th>
                                        <th style="width: 10%">ملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(
                                            pay, index
                                        ) in cuatomersWithdrawals"
                                        :key="index"
                                    >
                                        <td>{{ pay.customer_cash_id }}</td>
                                        <td>{{ pay.paid_value }}</td>
                                        <td>{{ pay.paid_date }}</td>
                                        <td>
                                            {{ pay.customer.cust_name }}
                                        </td>
                                        <td>{{ pay.user.name }}</td>
                                        <td>
                                            {{ pay.cust_balance_before }}
                                        </td>
                                        <td>{{ pay.cust_after_after }}</td>
                                        <td>
                                            {{
                                                pay.pay_methods.pay_method_name
                                            }}
                                        </td>

                                        <td>{{ pay.note }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p v-else class="text-center">
                                {{ __("No Data Yet") }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer mb-2 text-center text-light">
                        <a
                            class="btn btn-success"
                            data-toggle="modal"
                            data-target="#withdrawModal"
                            >إضافة</a
                        >
                        <router-link to="/bill" class="btn btn-danger"
                            >إغلاق</router-link
                        >
                    </div>
                </div>
                <Withdraw :customers="customers"></Withdraw>
            </div>
        </div>
    </div>
</template>

<script>
import Withdraw from "./withdraw";
import Pay from "./pay";

export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();

        this.allCustomers();
        this.customersPaid();
        this.customersWithdraw();
    },
    components: { Pay, Withdraw },
    data() {
        return {
            user: {},
            title: "Cash",
            customers: [],
            customersPay: [],
            cuatomersWithdrawals: [],
        };
    },
    methods: {
        async allCustomers() {
            await axios
                .get("/api/action/all/customers")
                .then(({ data }) => (this.customers = data))
                .catch((error) => console.log(error));
        },
        async customersPaid() {
            await axios
                .get("/api/action/customerPay/1")
                .then(({ data }) => (this.customersPay = data))
                .catch((error) => console.log(error));
        },
        async customersWithdraw() {
            await axios
                .get("/api/action/customerPay/0")
                .then(({ data }) => (this.cuatomersWithdrawals = data))
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style scoped></style>
