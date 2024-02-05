<template>
    <div v-if="bill" class="d-inline">
        <a id="book" class="btn btn-info text-light" :data-target="'#bookingModal' + bill.id" data-toggle="modal"><i
                class="fa fa-print"></i></a>
        <div :id="'bookingModal' + bill.id" aria-hidden="true" aria-labelledby="bookingModal" class="modal" role="dialog"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content m-auto">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="printMe" class="modal-body">
                        <div id="invoice-POS" class="pos-section">
                            <div style="text-align: center">
                                <div class="text-center">
                                    <img :src="mixins.mixins_logo" :style="{
                                        width: mixins.logo_width + 'px',
                                        height: mixins.logo_height + 'px',
                                    }" />
                                </div>
                                <div class="info">
                                    <span class="m-0">
                                        {{ mixins.mixins_name }}
                                    </span>
                                </div>
                                <div class="info">
                                    <span class="m-0">
                                        {{ mixins.contruct_no }}
                                    </span>
                                </div>
                                <div class="info">
                                    <span class="m-0">
                                        {{ mixins.mixins_adress }}
                                    </span>
                                </div>
                                <div class="info">
                                    <span class="m-0">
                                        {{ mixins.mixins_mobile }}
                                    </span>
                                </div>
                                <!--End Info-->

                                <div class="text-center">
                                    <span> فاتورة حجز</span>
                                </div>
                            </div>
                            <!--End InvoiceTop-->
                            <div id="bot">
                                <div id="table" class="table-responsive-sm">
                                    <table id="resultTable" class="text-center w-100">
                                        <tbody>
                                            <tr>
                                                <td>رقم الحجز
                                                    <p>Booking number</p>
                                                </td>
                                                <td>
                                                    {{ bill.id }}
                                                </td>
                                                <td>تاريخ الحجز
                                                    <p>Booking date</p>
                                                </td>
                                                <td>
                                                    {{
                                                        moment(
                                                            bill.bill_date
                                                        ).format(
                                                            "DD-MM-YYY HH:mm:ss"
                                                        )
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td v-if="bill.user != null">
                                                    مستخدم النظام
                                                    <p>user name</p>
                                                </td>
                                                <td v-if="bill.user != null">
                                                    {{ bill.user.name }}
                                                </td>

                                                <td v-if="bill.customer &&
                                                    bill.customer.cust_name
                                                    ">
                                                    العميل
                                                    <p>customer name</p>
                                                </td>
                                                <td v-if="bill.customer &&
                                                    bill.customer.cust_name
                                                    ">
                                                    {{
                                                        bill.customer.cust_name
                                                    }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.customer &&
                                                    bill.customer.cust_mobile
                                                    ">
                                                <td>الجوال
                                                    <p>customer mobile</p>
                                                </td>
                                                <td>
                                                    {{
                                                        bill.customer
                                                            .cust_mobile
                                                    }}
                                                </td>

                                                <td v-if="bill.customer &&
                                                        bill.customer
                                                            .cust_address
                                                        ">
                                                    العنوان
                                                    <p>customer address</p>
                                                </td>

                                                <td v-if="bill.customer &&
                                                    bill.customer
                                                        .cust_address
                                                    ">
                                                    {{
                                                        bill.customer
                                                            .cust_address
                                                    }}
                                                </td>
                                            </tr>

                                            <tr v-if="bill.customer &&
                                                    bill.customer.cust_balance
                                                    ">
                                                <td>رصيد العميل
                                                    <p>customer balance</p>
                                                </td>

                                                <td>
                                                    {{
                                                        bill.customer
                                                            .cust_balance
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="text-center w-100">
                                        <thead>
                                            <tr>
                                                <th>بيان</th>
                                                <th>عملية</th>
                                                <th>اجمالي</th>
                                                <th>موظف\ة</th>
                                                <th>كرسي</th>
                                                <th>الوقت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(
                                                                            type, index
                                                                        ) in bill.table_type" :key="index">
                                                <td class="text-center">
                                                    {{ type.type.type_name_ar }}
                                                    {{ type.type.type_name_en }}

                                                    <small class="d-block text-wrap">{{
                                                        type.type_note
                                                    }}</small>
                                                </td>

                                                <td class="text-center">
                                                    {{
                                                        type.units
                                                        ? type.units.unit
                                                            .unit_ar_name + "-" + type.units.unit
                                                            .unit_en_name
                                                        : "-"
                                                    }}
                                                </td>

                                                <td>
                                                    {{ type.type_total_price }}
                                                </td>
                                                <td>
                                                    {{ type.worker ? type.worker.name : '' }}
                                                </td>
                                                <td>
                                                    {{ type.chair ? type.chair.table_no : '' }}
                                                </td>
                                                <td>
                                                    {{
                                                        moment(
                                                            type.reserve_date
                                                        ).format(
                                                            "DD-MM HH:mm"
                                                        )
                                                    }}
                                                </td>
                                            </tr>
                                            <td colspan="2" v-if="bill.pay_methods != null">
                                                طريقة الدفع
                                                <p>payment method</p>
                                            </td>
                                            <td colspan="2" v-if="bill.pay_methods != null">
                                                {{
                                                    bill.pay_methods
                                                        .pay_method_name
                                                }}
                                            </td>
                                            <tr>
                                                <td colspan="2">
                                                    {{
                                                        bill.sum_after_discount >
                                                        0 &&
                                                        bill.sum_after_discount !=
                                                        bill.bill_sum
                                                        ? " المجموع الجزئي: sub total"
                                                        : " المجموع قبل الضريبة: total before vat"
                                                    }}
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_sum }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.bill_discount > 0 &&
                                                bill.offer_discount == 0
                                                ">
                                                <td colspan="2">
                                                    الخصم ({{
                                                        bill.bill_discount
                                                    }}%):
                                                    <p>discount</p>
                                                </td>

                                                <td colspan="2">
                                                    {{
                                                        bill.bill_discount_percent
                                                    }}
                                                </td>
                                            </tr>

                                            <tr v-if="bill.offer_discount > 0">
                                                <td colspan="2">
                                                    خصم عرض
                                                    {{ mixins.offer_percenet }}
                                                    %
                                                    <p>offer discount</p>
                                                </td>

                                                <td colspan="2">
                                                    {{ bill.offer_discount }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">العربون:
                                                    <p>retainer</p>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_paid_val }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.bill_extra > 0">
                                                <td colspan="2">الاضافي:
                                                    <p>extra</p>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_extra }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.sum_after_discount >
                                                0 &&
                                                bill.sum_after_discount !=
                                                bill.bill_sum
                                                ">
                                                <td colspan="2">المجموع:
                                                    <p>sum after discount</p>
                                                </td>
                                                <td colspan="2">
                                                    {{
                                                        bill.sum_after_discount
                                                    }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.bill_vat_val > 0">
                                                <td colspan="2">
                                                    ضريبة القيمة المضافة :
                                                    <p>vat</p>
                                                    <small class="d-block" v-if="mixins.mixins_price_include_vat
                                                        ">الاسعار شاملة
                                                        الضريبة</small>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_vat_val }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.bill_paid_val !=
                                                bill.bill_total &&
                                                bill.pay_methods &&
                                                bill.pay_methods.id != 4
                                                ">
                                                <td colspan="2">المدفوع:
                                                    <p>paid</p>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_paid_val }}
                                                </td>
                                            </tr>
                                            <tr v-else-if="bill.pay_methods &&
                                                bill.pay_methods.id == 4
                                                ">
                                                <td colspan="2">
                                                    المدفوع كاش :
                                                    <p>paid Cash</p>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.cash }}
                                                </td>
                                            </tr>
                                            <tr v-if="bill.bill_remain_val != 0 &&
                                                bill.pay_methods &&
                                                bill.pay_methods.id != 4
                                                ">
                                                <td colspan="2">الباقي:
                                                    <p>remain</p>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_remain_val }}
                                                </td>
                                            </tr>
                                            <tr v-else-if="bill.pay_methods &&
                                                bill.pay_methods.id == 4
                                                ">
                                                <td colspan="2">
                                                    المدفوع شبكة:
                                                    <p>paid Card</p>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.card }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">الاجمالي:
                                                    <p>total</p>
                                                </td>
                                                <td colspan="2">
                                                    {{ bill.bill_total }}
                                                    <!-- <small style="display: block">
                                                    {{ bill.billTotal }}</small
                                                > -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--End Table-->
                                <div v-if="mixins.mixins_note">
                                    <ul class="navbar-nav row text-center">
                                        <li class="col-12" v-for="(
                                                                        note, index
                                                                    ) in mixins.mixins_note.split(',')" :key="index">
                                            {{ note }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!--End InvoiceBot-->
                            <div v-if="bill.bill_notes" class="footer text-center text-wrap">
                                {{ bill.bill_notes }}
                            </div>
                            <div v-if="mixins.country == 2" class="footer text-center" style="
                                                            font-size: 8px;
                                                            font-weight: bolder;
                                                            margin-top: 3px;
                                                        ">
                                تقنيات اليوم للحلول البرمجية
                                <i class="fa fa-phone"></i>
                                +966557179844 -
                                <i class="fa fa-phone"></i> +966561420027 .
                            </div>
                            <div v-else class="footer text-center" style="
                                                            font-size: 8px;
                                                            font-weight: bolder;
                                                            margin-top: 3px;
                                                        ">
                                كوديز للحلول البرمجية
                                <i class="fa fa-phone"></i>
                                01002208627 -
                                <i class="fa fa-phone"></i> 01009199086 .
                            </div>
                        </div>
                        <!--End Invoice-->
                    </div>

                    <div class="modal-footer text-center">
                        <button id="print" class="btn btn-secondary" data-dismiss="modal" type="button">
                            إغلاق
                        </button>
                        <button id="printer" class="btn btn-success d-none" @click="print()">
                            طباعة
                        </button>
                        <button class="btn btn-success" @click="printOne()">
                            طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    props: ["bill"],

    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        let user = await Auth.getAuth();
        this.mixins = user.branch;

        this.orderNum = localStorage.getItem("orderNum");
    },
    updated() {
        this.orderNum = localStorage.getItem("orderNum");
    },
    data() {
        return {
            isDone: false,
            mixins: {},
            moment: moment,
            isclicked: false,
            mydata: [],
            billTotal: "",
            orderNum: 0,
        };
    },

    methods: {
        handlePrint() {
            var sOption = "toolbar=no,location=no,width=303,directories=yes,menubar=no,";
            sOption += "scrollbars=yes";
            var winPrint = window.open("", "", sOption);
            winPrint.document.open();
            winPrint.document.write("<html>");
            winPrint.document.write(`<head>
                <link href="${window.location.origin}/backend/vendor/bootstrap/css/bootstrap.rtl.css" rel="stylesheet" type="text/css">
                 <link href="${window.location.origin}/css/print.css" rel="stylesheet" type="text/css" >
                <link href="${window.location.origin}/css/print.css" rel="stylesheet" type="text/css" media="print">
            `);

            winPrint.document.write("<body ><div class='pos-section zoom'> ");
            winPrint.document.write('<input class="d-block  text-center m-auto btn btn-info hideBtn" type="button" value="طباعة" onclick="window.focus(); window.print();window.close(); return false; "');
            winPrint.document.write(
                document.getElementById("printMe").innerHTML
            );

            winPrint.document.write("</div></body></html>");
            winPrint.document.close();

            winPrint.focus();


        },
        printOne() {
            this.$htmlToPaper('printMe');
        },
        async print() {
            for (var count = 0; count < this.mixins.printer_count; count++) {
                this.$htmlToPaper('printMe');
            }
        },
    },
};
</script>

<style scoped>
</style>
