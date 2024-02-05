<template>
    <div v-if="bill && mixins">
        <a
            id="btn"
            class="btn btn-info text-light d-none"
            data-target="#printModal"
            data-toggle="modal"
            ><i class="fas fa-ellipsis-v"></i
        ></a>
        <div
            id="printModal"
            aria-hidden="true"
            aria-labelledby="printModal"
            class="modal fade A4"
            role="dialog"
            tabindex="-1"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document"
            >
                <div class="modal-content m-auto">
                    <div class="modal-header">
                        <button
                            aria-label="Close"
                            class="close"
                            data-dismiss="modal"
                            type="button"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="printMe" class="modal-body A4">
                        <div class="sheet padding-10mm">
                            <div style="text-align: center">
                                <h1>A4</h1>
                                <div class="text-center">
                                    <img
                                        :src="mixins.mixins_logo"
                                        style="
                                            width: 50px;
                                            height: 50px;
                                            border-radius: 50%;
                                        "
                                    />
                                </div>
                                <div>
                                    <span class="m-0">
                                        {{ mixins.mixins_name }}
                                    </span>
                                </div>
                                <div>
                                    <span class="m-0">
                                        {{ mixins.contruct_no }}
                                    </span>
                                </div>
                                <div>
                                    <span class="m-0">
                                        {{ mixins.mixins_adress }}
                                    </span>
                                </div>
                                <div>
                                    <span class="m-0">
                                        {{ mixins.mixins_mobile }}
                                    </span>
                                </div>
                                <!--End Info-->
                                <div
                                    v-if="bill.customer != null"
                                    class="text-center"
                                >
                                    <small
                                        v-if="
                                            bill.customer.cust_vat_num &&
                                            mixins.mixins_vat_val > 0
                                        "
                                    >
                                        فاتورة ضريبية
                                    </small>
                                    <small v-else="mixins.mixins_vat_val > 0"
                                        >فاتورة ضريبية مبسطة</small
                                    >
                                </div>
                                <div v-else class="text-center">
                                    <small
                                        v-if="
                                            mixins.mixins_vat_val > 0 &&
                                            mixins.contruct_no
                                        "
                                    >
                                        فاتورة ضريبية مبسطة</small
                                    >
                                </div>
                            </div>
                            <!--End InvoiceTop-->
                            <div>
                                <div>
                                    <table
                                        id="resultTable"
                                        class="text-center w-100"
                                    >
                                        <tr>
                                            <td colspan="1" class="no-border">
                                                رقم الفاتورة
                                            </td>
                                            <td colspan="3" class="no-border">
                                                {{ bill.bill_no }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="no-border">
                                                تاريخ الفاتورة
                                            </td>
                                            <td colspan="3" class="no-border">
                                                {{
                                                    moment(
                                                        bill.bill_date
                                                    ).format("DD-MM-YYYY")
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                colspan="1"
                                                class="no-border"
                                                v-if="bill.user != null"
                                            >
                                                مستخدم النظام
                                            </td>
                                            <td
                                                colspan="3"
                                                class="no-border"
                                                v-if="bill.user != null"
                                            >
                                                {{ bill.user.name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                colspan="1"
                                                class="no-border"
                                                v-if="bill.pay_methods != null"
                                            >
                                                طريقة الدفع
                                            </td>
                                            <td
                                                colspan="3"
                                                class="no-border"
                                                v-if="bill.pay_methods != null"
                                            >
                                                {{
                                                    bill.pay_methods
                                                        .pay_method_name
                                                }}
                                            </td>
                                        </tr>
                                        <td colspan="4">
                                            <hr class="hr-line" />
                                        </td>
                                        <tr v-if="bill.customer">
                                            <td colspan="1" class="no-border">
                                                اسم العميل
                                            </td>
                                            <td colspan="3" class="no-border">
                                                {{ bill.customer.cust_name }}
                                            </td>
                                        </tr>
                                        <tr v-if="bill.customer">
                                            <td colspan="1" class="no-border">
                                                هاتف العميل
                                            </td>
                                            <td colspan="3" class="no-border">
                                                {{ bill.customer.cust_mobile }}
                                            </td>
                                        </tr>

                                        <tr
                                            v-if="
                                                bill.customer &&
                                                bill.customer.cust_address
                                            "
                                        >
                                            <td colspan="1" class="no-border">
                                                عنوان العميل
                                            </td>

                                            <td colspan="3" class="no-border">
                                                {{ bill.customer.cust_address }}
                                            </td>
                                        </tr>
                                        <tr
                                            v-if="
                                                bill.customer &&
                                                bill.customer.cust_vat_num
                                            "
                                        >
                                            <td colspan="1" class="no-border">
                                                الرقم الضريبي للعميل
                                            </td>
                                            <td colspan="3" class="no-border">
                                                {{ bill.customer.cust_vat_num }}
                                            </td>
                                        </tr>
                                        <tr v-if="bill.customer">
                                            <td colspan="1" class="no-border">
                                                رصيد العميل
                                            </td>

                                            <td colspan="3" class="no-border">
                                                {{ bill.customer.cust_balance }}
                                            </td>
                                        </tr>

                                        <tr class="text-center">
                                            <th style="width: 40%">
                                                اسم الصنف
                                            </th>
                                            <th style="width: 20%">العدد</th>
                                            <th style="width: 20%">السعر</th>
                                            <th style="width: 20%">الاجمالي</th>
                                        </tr>
                                        <tr
                                            v-for="(
                                                type, index
                                            ) in bill.bill_type"
                                            :key="index"
                                            class="ErrorRow"
                                        >
                                            <td>
                                                {{ type.type.type_name_ar }}
                                                <small class="d-block">{{
                                                    type.type_note
                                                }}</small>
                                            </td>
                                            <td class="text-center">
                                                {{ type.type_count }}
                                            </td>

                                            <td class="text-center">
                                                {{ type.type_price }}
                                            </td>
                                            <td class="text-center">
                                                {{ type.type_total_price }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" class="no-border">
                                                المجموع:
                                            </td>
                                            <td colspan="2" class="no-border">
                                                {{ bill.bill_sum }}
                                            </td>
                                        </tr>
                                        <tr v-if="bill.bill_discount > 0">
                                            <td colspan="2" class="no-border">
                                                الخصم ({{
                                                    bill.bill_discount_percent
                                                }}%):
                                            </td>
                                            <td colspan="2" class="no-border">
                                                {{ bill.bill_discount }}
                                            </td>
                                        </tr>

                                        <tr v-if="bill.bill_extra > 0">
                                            <td colspan="2" class="no-border">
                                                الاضافي:
                                            </td>
                                            <td colspan="2" class="no-border">
                                                {{ bill.bill_extra }}
                                            </td>
                                        </tr>
                                        <tr v-if="bill.bill_vat_val > 0">
                                            <td colspan="2" class="no-border">
                                                ضريبة القيمة المضافة ({{
                                                    mixins.mixins_vat_val
                                                }}%):
                                            </td>
                                            <td colspan="2" class="no-border">
                                                {{ bill.bill_vat_val }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="no-border">
                                                الاجمالي:
                                            </td>
                                            <td colspan="2" class="no-border">
                                                {{ bill.bill_total }}
                                            </td>
                                        </tr>
                                        <tr
                                            v-if="
                                                bill.bill_paid_val !=
                                                bill.bill_total
                                            "
                                        >
                                            <td colspan="2" class="no-border">
                                                المدفوع:
                                            </td>
                                            <td colspan="2" class="no-border">
                                                {{ bill.bill_paid_val }}
                                            </td>
                                        </tr>
                                        <tr v-if="bill.bill_remain_val != 0">
                                            <td colspan="2" class="no-border">
                                                الباقي:
                                            </td>
                                            <td colspan="2" class="no-border">
                                                {{ bill.bill_remain_val }}
                                            </td>
                                        </tr>
                                        <td colspan="4">
                                            <hr class="hr-line" />
                                        </td>
                                    </table>
                                </div>
                                <!--End Table-->
                                <div v-if="mixins.mixins_note">
                                    <ul class="navbar-nav row text-center">
                                        <li
                                            class="col-12"
                                            v-for="(
                                                note, index
                                            ) in mixins.mixins_note.split(',')"
                                            :key="index"
                                        >
                                            {{ note }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div
                                v-if="
                                    mixins.mixins_name != null &&
                                    !mixins.mixins_name.isEmpty &&
                                    mixins.contruct_no != null
                                "
                                class="text-center"
                            >
                                <img :src="qr" height="120" />
                            </div>
                            <!--End InvoiceBot-->
                        </div>
                        <!--End Invoice-->
                    </div>
                    <div class="modal-footer text-center">
                        <button
                            id="print"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            type="button"
                        >
                            إغلاق
                        </button>
                        <button
                            id="printer"
                            class="btn btn-success d-none"
                            @click="print()"
                        >
                            طباعة
                        </button>
                        <button
                            id="printOne"
                            class="btn btn-success"
                            @click="printOne()"
                        >
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
import Cookie from "../Helpers/Cookie";

export default {
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        let user = await Auth.getAuth();
        this.mixins = user.branch;
    },
    props: ["bill", "qr"],
    data() {
        return {
            isDone: false,
            mixins: {},
            moment: moment,
        };
    },
    methods: {

        print() {
            let billCopy = Cookie.checkCookie("copy") ?? 1;
            for (var count = 1; count <= billCopy; count++) {
                this.$htmlToPaper("printMe");
            }
        },
        printOne() {
            this.$htmlToPaper("printMe");
        },
    },
};
</script>

<style scoped></style>
