<template>
    <div id="invoice-POS" class="pos-section">
        <div class="card mb-4">
            <div class="accordion-item">
                <h2 class="accordion-header card-header" id="headingTwo">
                    <div
                        class=" w-100 d-flex justify-content-between "
                    >
                        <h6 class="m-0 font-weight-bold text-primary">
                            <button
                                class="collapsed btn btn-secondary font-weight-bold text-light"
                                @click="show = !show"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo"
                                aria-expanded="false"
                                aria-controls="collapseTwo"
                            >
                                {{ __("Sales Bills  Report") }}
                                <i
                                    v-if="show"
                                    class="fa fa-angle-double-down"
                                ></i>
                                <i v-else class="fa fa-angle-double-up"></i>
                            </button>
                        </h6>
                        <i
                            class="fas fa-file-excel text-success hideMeInPrint"
                            style="cursor: pointer"
                            onclick="download('xlsx','bills');"
                        ></i>
                    </div>
                </h2>
                <div
                    id="collapseTwo"
                    :class="
                        show
                            ? 'accordion-collapse collapse show'
                            : 'accordion-collapse collapse'
                    "
                    aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body px-0 table-responsive ">
                        <table
                            id="bills"
                            class="text-center table-bordered"
                            style="
                                cellpadding: 20px;
                                cellspacing: 0px;
                                width: 100%;
                            "
                        >
                            <thead>
                                <tr>
                                    <th style="width: 5%">
                                        {{ __("Bill Number") }}
                                    </th>
                                    <th>
                                        {{ __("Branch_id") }}
                                    </th>
                                    <th

                                        style="width: 10%"
                                    >
                                        {{ __("Sum") }}
                                    </th>
                                    <th

                                        style="width: 10%"
                                    >
                                        {{ __("Vat") }}
                                    </th>
                                    <th style="width: 10%">
                                        {{ __("Total") }}
                                    </th>
                                    <th style="width: 5%">
                                        {{ __("Discount") }}
                                    </th>
                                    <th

                                        style="width: 10%"
                                    >
                                        {{ __("Paid") }}
                                    </th>
                                    <th

                                        style="width: 10%"
                                    >
                                        {{ __("Remain") }}
                                    </th>
                                    <th

                                        style="width: 20%"
                                    >
                                        {{ __("Bill Date") }}
                                    </th>
                                    <th style="width: 5%">
                                        {{ __("Pay Methods") }}
                                    </th>
                                    <th

                                        style="width: 10%"
                                    >
                                        {{ __("Customer Name") }}
                                    </th>
                                    <th

                                        style="width: 10%"
                                    >
                                        {{ __("User Name") }}
                                    </th>
                                    <th

                                        style="width: 10%"
                                    >
                                        {{ __("Notes") }}
                                    </th>
                                    <th class="hideMeInPrint"
                                        v-show="user.reprint_bill"

                                        style="width: 10%"
                                    >
                                        {{ __("Print") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="bill in bills"
                                    :key="bill.bill_no"
                                    @click="selected = bill.bill_no"
                                    :class="
                                        selected === bill.bill_no
                                            ? 'selected '
                                            : ''
                                    "
                                >
                                    <td>
                                        {{ bill.id }}
                                    </td>
                                    <td>
                                        {{ bill.branch.mixins_name }}
                                    </td>
                                    <td>
                                        {{ bill.bill_sum }}
                                    </td>
                                    <td >
                                        {{ bill.bill_vat_val }}
                                    </td>
                                    <td>
                                        {{ bill.bill_total }}
                                    </td>
                                    <td>
                                        {{ bill.bill_discount }}
                                        <span v-if="bill.bill_discount_percent"
                                            >%</span
                                        >
                                    </td>
                                    <td >
                                        {{ bill.bill_paid_val }}
                                    </td>
                                    <td >
                                        {{ bill.bill_remain_val }}
                                    </td>
                                    <td >
                                        {{ bill.bill_date }}
                                    </td>
                                    <td>
                                        {{
                                            bill.pay_methods
                                                ? bill.pay_methods
                                                      .pay_method_name
                                                : ""
                                        }}
                                    </td>
                                    <td >
                                        {{
                                            bill.customer
                                                ? bill.customer.cust_name
                                                : ""
                                        }}
                                    </td>
                                    <td >
                                        {{ bill.user ? bill.user.name : "" }}
                                    </td>
                                    <td
                                        :title="bill.bill_notes"
                                        style="max-width: 100px"

                                    >
                                        {{ bill.bill_notes }}
                                    </td>
                                    <td class="hideMeInPrint"
                                        v-show="user.reprint_bill"

                                    >
                                        <a
                                            class="btn btn-sm btn-success"
                                            @click="print(bill)"
                                        >
                                            <i
                                                class="fa fa-print text-light"
                                            ></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <Calculation :calc="calcBills" colspan="2" />
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Printer
            :bill="bill"
            :qr="qr"
            v-if="mixins.printer_type == 1"
            :isSendToKetchen="false"
        />
        <A4Printer :bill="bill" :qr="qr" v-else />
    </div>
</template>

<script>
import Printer from "../printer";
import Spinner from "../spinner/loading.vue";
import { Invoice } from "@axenda/zatca";
import Calculation from "./calculation.vue";
import A4Printer from "../A4Printer.vue";

export default {
    name: "Bills",
    props: ["bills", "calcBills"],
    components: { Printer, Spinner, Calculation, A4Printer },

    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }

        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;

        this.period = this.$route.params.period;
    },
    data() {
        return {
            user: {},
            selected: "",
            loading: true,
            bill: null,
            show: true,
            qr: "",
            mixins: {},
        };
    },
    methods: {
        async print(bill) {
            this.bill = bill;
            if (this.bill != null) {
                const invoice = new Invoice({
                    sellerName: this.mixins.mixins_name,
                    vatRegistrationNumber: this.mixins.contruct_no,
                    invoiceTimestamp: this.bill.bill_date,
                    invoiceTotal: this.bill.bill_total,
                    invoiceVatTotal: this.bill.bill_vat_val,
                });
                this.qr = await invoice.render();
            }
            $("#btn").click();
        },
    },
};
</script>
