<template>
    <div class="table-responsive">
    <table id="cashs" class="table align-items-center sortTable">
        <thead>
            <tr>
                <th style="width: 10%">رقم المستند</th>
                <th style="width: 10%">المبلغ</th>
                <th style="width: 10%">التاريخ</th>
                <th style="width: 10%">اسم العميل</th>
                <th style="width: 10%">اسم المستخدم</th>
                <th style="width: 10%">رصيد العميل قبل</th>
                <th style="width: 10%">رصيد العميل بعد</th>
                <th style="width: 10%">طريقة الدفع</th>
                <th style="width: 10%">ملاحظات</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(pay, index) in cashs" :key="index">
                <td>{{ pay.customer_cash_id }}</td>
                <td>{{ pay.paid_value }}</td>
                <td>{{ pay.paid_date }}</td>
                <td>{{ pay.customer.cust_name }}</td>
                <td>{{ pay.user.name }}</td>
                <td>{{ pay.cust_balance_before }}</td>
                <td>{{ pay.cust_after_after }}</td>
                <td>{{ pay.pay_methods.pay_method_name }}</td>

                <td>{{ pay.note }}</td>
            </tr>
        </tbody>
    </table>
    </div>
</template>

<script>
export default {
    props: ["cashs", "showCash"],
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
    },
    data() {
        return {};
    },
};
</script>

<style scoped></style>
