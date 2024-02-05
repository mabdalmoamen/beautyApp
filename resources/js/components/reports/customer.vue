<template>
    <div class="row">
        <!--            Customers Dialog-->
        <div id="exampleModal" aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" role="dialog"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content m-auto" style="min-width: 850px">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table align-items-center">
                                <thead>
                                    <tr>
                                        <th class="col-header" style="width: 50%">
                                            {{ __("Code") }}
                                        </th>
                                        <th class="col-header" style="width: 30%">
                                            {{ __("Customer Name") }}
                                        </th>
                                        <th class="col-header" style="width: 10%">
                                            {{ __("Mobile") }}
                                        </th>
                                        <th class="col-header" style="width: 10%">
                                            {{ __("Balance") }}
                                        </th>
                                        <th class="col-header" style="width: 10%">
                                            {{ __("Select") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(customer, index) in customers" :key="index">
                                        <td>{{ customer.cust_id }}</td>
                                        <td>
                                            {{ customer.cust_name }}
                                        </td>
                                        <td>
                                            {{ customer.cust_mobile }}
                                        </td>
                                        <td>
                                            {{ customer.cust_balance }}
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-dismiss="modal" @click="
                                                selectCustomer(customer)
                                                ">
                                                <i class="fa fa-plus font-weight-bold text-light"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--End Cusomer Dialog-->
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4" id="allReport">
                <div class="card-header d-flex flex-row align-items-center justify-content-between hideMeInPrint">
                    <h1 class="text-center my-0 btn-sm d-block">
                        {{ __("Customers Report") }}
                    </h1>
                    <i class="fas fa-file-excel text-success hideMeInPrint" style="cursor: pointer"
                        onclick="download('xlsx','bills');"></i>

                    <table class="w-25">
                        <tr>
                            <td style="width: 10%">{{ __("Code") }}</td>
                            <td style="width: 10%">
                                <input v-model="search" class="form-control-sm" type="text" @keyup="findCustomer" />
                            </td>
                            <td style="width: 10%">
                                {{ __("Customer Name") }}
                            </td>
                            <td style="width: 10%">
                                <input :value="customer.cust_name" class="form-control-sm" placeholder="" type="text" />
                            </td>
                            <td style="width: 10%">
                                <a :title="customer.cust_balance" class="btn btn-info btn-sm text-light"
                                    data-target="#exampleModal" data-toggle="modal" @click="allCustomers()"><i
                                        class="fas fa-search font-weight-bold text-light"></i></a>
                            </td>
                        </tr>
                    </table>
                    <button class="btn btn-success btn-sm" onclick="window.print()" type="submit">
                        {{ __("Print") }}
                    </button>

                    <form class="needs-validation mt-2 hideMeInPrint" v-show="!period" @submit.prevent="veiwReport">
                        <div class="form-row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend input-sm">
                                        <span for="from" class="input-group-text">{{ __("From") }}</span>
                                    </div>
                                    <date-picker v-model="reportPeriod.form" id="from" :wrap="true" :config="configs.wrap"
                                        required :placeholder="__('From')">
                                    </date-picker>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend float-right input-sm">
                                        <span class="input-group-text" for="to">{{ __("To") }}</span>
                                    </div>
                                    <date-picker v-model="reportPeriod.to" id="to" :wrap="true" :config="configs.wrap"
                                        required :placeholder="__('To')">
                                    </date-picker>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" type="submit">
                                    {{ __("View") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div style="height: 100vh">
                    <Bills :bills="bills" />
                    <div class="card mb-4">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <button class="collapsed btn btn-secondary font-weight-bold text-light" @click="
                                            showCash = !showCash;
                                        allCustomerCash();
                                        " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            كشف حساب عميل
                                            <i v-if="showCash" class="fa fa-angle-double-down"></i>
                                            <i v-else="" class="fa fa-angle-double-up"></i>
                                        </button>
                                    </h6>

                                    <i class="fas fa-file-excel text-success" style="cursor: pointer"
                                        onclick="download('xlsx','cashs');"></i>
                                </div>
                            </h2>
                            <div id="collapseTwo" :class="showCash
                                ? 'accordion-collapse collapse show'
                                : 'accordion-collapse collapse'
                                " aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body px-0">
                                    <div class="card-body">
                                        <Cash :cashs="cashs" :showCash="showCash"></Cash>
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
import Bills from "./bills";
import Cash from "./cash";
import datePicker from "../date/index";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";

export default {
    components: { Bills, Cash, datePicker },
    created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.period = this.$route.params.period;
        this.$route.params.period == "daily"
            ? (this.reportName = "اليوم")
            : this.$route.params.period == "monthly"
                ? (this.reportName = "الشهر")
                : (this.reportName = "الفترة");
        this.allCustomerBill();
    },
    data() {
        return {
            configs: {
                wrap: {
                    allowInputToggle: true,
                },
            },
            bills: [],
            showCash: false,
            selectCustomer(customer) {
                this.customer = customer;
                this.search = customer.cust_id;
            },
            purachaseBills: [],
            searchTerm: "",
            period: false,
            reportName: "",
            hideMe: false,
            reportPeriod: {
                to: null,
                form: null,
            },
            configs: {
                wrap: {
                    allowInputToggle: true,
                },
            },
            total: 1,
            page: 1,
            current_page: "",
            customer: {},
            customers: "",
            search: "",
            cashs: [],
        };
    },
    methods: {
        async findCustomer() {
            await axios
                .get("/api/customers/" + this.search)
                .then(({ data }) => {
                    this.customer = data;
                })
                .catch((error) => console.log(error));
        },
        async allCustomers() {
            await axios
                .get("/api/action/all/customers")
                .then(({ data }) => (this.customers = data))
                .catch((error) => console.log(error));
        },

        veiwReport() {
            this.allCustomerBill();
        },
        allCustomerBill() {
            if (
                this.reportPeriod.form != null &&
                this.reportPeriod.to != null
            ) {
                axios
                    .get(
                        "/api/customer/report/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to +
                        "/" +
                        this.customer.cust_id
                    )
                    .then(({ data }) => {
                        // this.loading = false;
                        this.bills = data;
                    })
                    .catch((error) => console.log(error));
            }
        },
        allCustomerCash() {
            if (
                this.reportPeriod.form != null &&
                this.reportPeriod.to != null
            ) {
                axios
                    .get(
                        "/api/customer/pay/" +
                        this.reportPeriod.form +
                        "/" +
                        this.reportPeriod.to +
                        "/" +
                        this.customer.cust_id
                    )
                    .then(({ data }) => {
                        if (data.length >= 0) {
                            this.cashs = data;
                            console.log(this.cashs);
                        }
                    })
                    .catch((error) => console.log(error));
            }
        },
        hideMeInPrint() {
            this.hideMe = !this.hideMe;
        },
    },
};
</script>
<style>
input {
    border: 1px solid #c4c4c4;
    border-radius: 5px;
    background-color: #fff;
    padding: 3px 5px;
    box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
}

@media print {
    .hideMeInPrint {
        display: none;
    }
}
</style>
