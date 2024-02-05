<template>
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div
                    class="card-header d-flex flex-row align-items-center justify-content-between"
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
                        {{ __("Purchases Bills") }}
                    </h6>

                    <button
                        class="hideMeInPrint btn btn-success btn-sm"
                        onclick="window.print()"
                        type="submit"
                    >
                        {{ __("Print") }}
                    </button>

                    <h6
                        class="m-0 hideMeInPrint font-weight-bold text-primary float-left"
                    >
                        <div id="search">
                            <input
                                id="filter"
                                class="form-control-sm"
                                name="filter"
                                type="text"
                                value=""
                            />
                        </div>
                    </h6>
                    <form
                        v-show="!period"
                        class="needs-validation mt-2 hideMeInPrint"
                        @submit.prevent="allBills"
                    >
                        <div class="form-row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend input-sm">
                                        <span
                                            id="validationTooltipUsernamePrepend"
                                            class="input-group-text"
                                            >{{ __("From") }}</span
                                        >
                                    </div>
                                    <input
                                        id="validationTooltipUsername"
                                        v-model="reportPeriod.from"
                                        aria-describedby="validationTooltipUsernamePrepend"
                                        class="form-control"
                                        placeholder="Username"
                                        required
                                        type="date"
                                    />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div
                                        class="input-group-prepend float-right input-sm"
                                    >
                                        <span
                                            class="input-group-text"
                                            for="to"
                                            >{{ __("To") }}</span
                                        >
                                    </div>
                                    <input
                                        v-model="reportPeriod.to"
                                        aria-describedby="validationTooltipUsernamePrepend"
                                        class="form-control"
                                        placeholder="Username"
                                        required
                                        type="date"
                                    />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button
                                    class="btn btn-success btn-sm"
                                    type="submit"
                                >
                                    {{ __("View") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div
                    class="table-responsive  table-wrapper"
                    style="height: 50vh"
                >
                    <table
                        v-if="bills.length > 0"
                        id="purchases"
                        class="text-center table-bordered"
                        style="cellpadding: 20px; cellspacing: 0px; width: 100%"
                    >
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    {{ __("Bill Number") }}
                                </th>
                                <th style="width: 5%">
                                    {{ __("Bill Serial") }}
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
                                <th style="width: 5%">
                                    {{ __("Discount") }}
                                </th>
                                <th style="width: 10%">
                                    {{ __("Paid") }}
                                </th>
                                <th style="width: 10%">
                                    {{ __("Remian") }}
                                </th>
                                <th style="width: 20%">
                                    {{ __("Bill Date") }}
                                </th>
                                <th style="width: 10%">
                                    {{ __("Supplier") }}
                                </th>
                                <th style="width: 10%">
                                    {{ __("User") }}
                                </th>
                                <th style="width: 10%">
                                    {{ __("Notes") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="bill in bills"
                                :key="bill.purchase_bill_no"
                                class="ErrorRow"
                                @click="
                                    showBillDetails(bill.bill_type);
                                    selected = bill.purchase_bill_no;
                                "
                            >
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.purchase_bill_no }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.bill_serial }}
                                </td>

                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.bill_sum }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.bill_vat_val }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.bill_total }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.bill_discount_val }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.bill_paid_val }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.bill_remain_val }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.bill_date }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{
                                        bill.supplier
                                            ? bill.supplier.supplier_name
                                            : ""
                                    }}
                                </td>
                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.user ? bill.user.name : "" }}
                                </td>

                                <td
                                    :class="
                                        selected === bill.purchase_bill_no
                                            ? 'selected'
                                            : ''
                                    "
                                >
                                    {{ bill.purchase_bill_notes }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p v-else class="text-center">
                        {{ __("No Data Yet") }}
                    </p>
                </div>
                <div
                    class="table-responsive hideMeInPrint"
                    style="height: 50vh"
                >
                    <div class="row text-center">
                        <th class="col-1">{{ __("Code") }}</th>
                        <th class="col-2">{{ __("Type Name") }}</th>
                        <th class="col-1">{{ __("Count") }}</th>
                        <th class="col-1">{{ __("Purchase Price") }}</th>

                        <th class="col-1">{{ __("Total") }}</th>
                        <th class="col-5">{{ __("Notes") }}</th>
                    </div>
                    <div
                        v-for="type in billTypes"
                        :key="type.bill_type_id"
                        class="text-center row"
                    >
                        <td class="col-1">{{ type.type_id }}</td>
                        <td class="col-2">{{ type.type.title }}</td>
                        <td class="col-1">{{ type.type_count }}</td>
                        <td class="col-1">
                            {{ type.type_purchase_price }}
                        </td>

                        <td class="col-1">
                            {{ type.total_purchase_price }}
                        </td>
                        <td class="col-5">{{ type.type_note }}</td>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";

export default {
    components: { Spinner },

    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        await axios
            .get("/api/users/" + localStorage.getItem("user_id"))
            .then(({ data }) => (this.user = data))
            .catch((error) => console.log(error));
        this.calcDate();
        this.allBills();
    },
    data() {
        return {
            user: {},
            selected: "",

            bills: [],
            searchTerm: "",
            period: false,
            reportName: "",
            hideMe: false,
            total: 1,
            page: 1,
            current_page: "",
            reportPeriod: {
                to: null,
                from: null,
            },
            billTypes: [],
        };
    },
    computed: {
        filterSearch() {
            return bills.length > 0
                ? this.bills.filter((bill) => {
                      return bill.purchase_bill_no.match(this.searchTerm);
                  })
                : "";
        },
    },
    methods: {
        nextPage(i) {
            this.page = i;
            this.allBills();
        },
        allBills() {
            axios
                .get(
                    "/api/bill/purchases/report/" +
                        this.period +
                        "/" +
                        this.reportPeriod.from +
                        "/" +
                        this.reportPeriod.to
                )
                .then(({ data }) => {
                    if (data.length >= 0) {
                        // this.loading = false;
                        this.bills = data;
                    }
                })
                .catch((error) => console.log(error));
        },
        showBillDetails(bill) {
            this.billTypes = bill;
        },
        calcDate() {
            var lastDate = new Date();
            lastDate.setDate(lastDate.getDate() - 5);
            var currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 1);
            this.reportPeriod.from = lastDate
                .toJSON()
                .slice(0, 10)
                .replace(/-/g, "-");
            this.reportPeriod.to = currentDate
                .toJSON()
                .slice(0, 10)
                .replace(/-/g, "-");
        },
    },
};
</script>
<style>
@media print {
    .hideMeInPrint {
        display: none;
    }
}
</style>
