<template>
    <div id="pagewrap">
        <div id="body">
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
                                        @click="show = !show"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo"
                                        aria-expanded="false"
                                        aria-controls="collapseTwo"
                                    >
                                        {{ __("Purchase Bills  Report") }}
                                        <i
                                            v-if="show"
                                            class="fa fa-angle-double-down"
                                        ></i>
                                        <i
                                            v-else=""
                                            class="fa fa-angle-double-up"
                                        ></i>
                                    </button>
                                </h6>

                                <i
                                    class="fas fa-file-excel text-success hideMeInPrint"
                                    style="cursor: pointer"
                                    onclick="download('xlsx','purachaseBills');"
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
                            <div class="accordion-body px-0">
                                <div class="card-body">
                                    <div class="w-100 table-responsive table-wrapper">
                                        <table
                                            class="text-center table-bordered"
                                            style="
                                                cellpadding: 20px;
                                                cellspacing: 0px;
                                                width: 100%;
                                            "
                                            id="purachaseBills"
                                        >
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="col-header"
                                                        style="width: 5%"
                                                    >
                                                        {{ __("Bill Number") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("Sum") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("Vat") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("Total") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 5%"
                                                    >
                                                        {{ __("Discount") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("Paid") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("Remian") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 20%"
                                                    >
                                                        {{ __("Bill Date") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("Supplier") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("PayMethod") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("User") }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{ __("Notes") }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="bill in purachaseBills"
                                                    :key="bill.purchase_bill_no"
                                                    @click="
                                                        selected =
                                                            bill.purchase_bill_no
                                                    "
                                                >
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{
                                                            bill.purchase_bill_no
                                                        }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{ bill.bill_sum }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{ bill.bill_vat_val }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{ bill.bill_total }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{
                                                            bill.bill_discount_val
                                                        }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{ bill.bill_paid_val }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{
                                                            bill.bill_remain_val
                                                        }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{ bill.bill_date }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{
                                                            bill.supplier
                                                                .supplier_name
                                                        }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{
                                                            bill.pay_methods
                                                                .pay_method_name
                                                        }}
                                                    </td>

                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{
                                                            bill.user
                                                                ? bill.user.name
                                                                : ""
                                                        }}
                                                    </td>
                                                    <td
                                                        :class="
                                                            selected ===
                                                            bill.purchase_bill_no
                                                                ? 'selected'
                                                                : ''
                                                        "
                                                    >
                                                        {{
                                                            bill.purchase_bill_notes
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <Calculation
                                                :calc="calcPur"
                                                colspan="2"
                                            />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Calculation from "./calculation.vue";

export default {
    name: "purachaseBills",
    props: ["purachaseBills", "calcPur"],
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;

        this.period = this.$route.params.period;
    },
    data() {
        return {
            user: {},
            selected: "",
            show: false,
        };
    },
    components: { Calculation },
};
</script>
