<template>
    <div class="row justify-content-center">
        <div class="card mb-4">
            <div class="accordion-item">
                <h2 class="accordion-header card-header" id="headingTwo">
                    <div
                        class="w-100 d-flex justify-content-between"
                    >
                        <h6 class="m-0 font-weight-bold text-primary">
                            <button
                                class="collapsed btn btn-secondary font-weight-bold text-light"
                                @click="showBill = !showBill"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo"
                                aria-expanded="false"
                                aria-controls="collapseTwo"
                            >
                                {{ __("Process Bills Report") }}
                                <i
                                    v-if="showBill"
                                    class="fa fa-angle-double-down"
                                ></i>
                                <i v-else class="fa fa-angle-double-up"></i>
                            </button>
                        </h6>
                        <i
                            class="fas fa-file-excel text-success hideMeInPrint"
                            style="cursor: pointer"
                            onclick="download('xlsx','process');"
                        ></i>
                    </div>
                </h2>
                <div
                    id="collapseTwo"
                    :class="
                        showBill
                            ? 'accordion-collapse collapse show'
                            : 'accordion-collapse collapse'
                    "
                    aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body px-0">
                        <div class="card-body table-responsive">
                            <table
                                id="process"
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
                                            {{ __("Notification No") }}
                                        </th>
                                        <th style="width: 5%">
                                            {{ __("Bill Number") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Sum") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Vat") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Total") }}
                                        </th>

                                        <th style="width: 20%">
                                            {{ __("Bill Date") }}
                                        </th>

                                        <th style="width: 10%">
                                            {{ __("User Name") }}
                                        </th>

                                        <th
                                            class="hideMeInPrint"
                                            style="width: 10%"
                                        >
                                            {{ __("Print") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="pro in process"
                                        :key="pro.bill_no"
                                        @click="selected = pro.bill_no"
                                    >
                                        <td
                                            :class="
                                                selected === pro.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ pro.return_id }}
                                        </td>
                                        <td
                                            :class="
                                                selected === pro.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ pro.bill_no }}
                                        </td>
                                        <td
                                            :class="
                                                selected === pro.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ pro.sum }}
                                        </td>
                                        <td
                                            :class="
                                                selected === pro.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ pro.vat }}
                                        </td>
                                        <td
                                            :class="
                                                selected === pro.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ pro.total }}
                                        </td>

                                        <td
                                            :class="
                                                selected === pro.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ pro.returns_date }}
                                        </td>

                                        <td
                                            :class="
                                                selected === pro.bill_no
                                                    ? 'selected'
                                                    : ''
                                            "
                                        >
                                            {{ pro.user ? pro.user.name : "" }}
                                        </td>

                                        <td
                                            :class="
                                                selected === pro.bill_no
                                                    ? 'selected hideMeInPrint'
                                                    : 'hideMeInPrint'
                                            "
                                        >
                                            <a
                                                class="btn btn-sm btn-success"
                                                @click="print(pro)"
                                            >
                                                <i
                                                    class="fa fa-print text-light"
                                                ></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="width: 10%">
                                            اجمالي جميع الفواتير
                                        </th>
                                        <th style="width: 10%">
                                            {{ calcProcess.total }}
                                        </th>
                                        <th colspan="3" style="width: 10%">
                                            اجمالي الضريبة
                                        </th>
                                        <th style="width: 10%">
                                            {{ calcProcess.Vat }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Rprinter :bill="bill" :qr="qr" />
    </div>
</template>

<script>
import Printer from "../printer";
import Spinner from "../spinner/loading.vue";
import { Invoice } from "@axenda/zatca";
import Rprinter from "../rprinter.vue";

export default {
    name: "Process",
    props: ["process", "calcProcess", "mixins"],
    components: { Printer, Rprinter, Spinner },

    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.codies = this.user.branch;
        this.period = this.$route.params.period;
    },
    data() {
        return {
            selected: "",
            loading: true,
            bill: null,
            show: false,
            showBill: true,
            qr: "",
            codies: {},
        };
    },
    methods: {
        async findBill(bill_no) {
            await axios
                .get("/api/bills/" + bill_no)
                .then(async ({ data }) => {
                    this.bill = data;
                })

                .catch((error) => console.log(error));
        },
        async print(bill) {
            await this.findBill(bill.bill_no);
            if (this.bill != null) {
                const invoice = new Invoice({
                    sellerName: this.codies.mixins_name,
                    vatRegistrationNumber: this.codies.contruct_no,
                    invoiceTimestamp: this.bill.returns.returns_date,
                    invoiceTotal: this.bill.returns.total,
                    invoiceVatTotal: this.bill.returns.vat,
                });
                this.qr = await invoice.render();
            }
            $("#Rbtn").click();
        },
    },
};
</script>
