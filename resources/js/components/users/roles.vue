<template>
    <div class="card border-1">
        <form @submit.prevent="update">
            <div class="card-header">
                <div class="controls text-center">
                    <h1 class="my-3">اختيار الصلاحيات</h1>
                    <button type="button" class="btn btn-warning text-light float-right" @click="$router.go(-1)">
                        <i :class="$root.$data.codies.default_lang == 'ar'
                            ? 'fa fa-arrow-right'
                            : 'fa fa-arrow-left'
                            "></i>
                    </button>
                    <button v-if="showAll" type="button" class="btn btn-info" id="Collepsed" @click="fadeOut">
                        تصغير
                    </button>
                    <button v-else type="button" class="btn btn-info" id="Collepsed" @click="fadeIn">
                        تكبير
                    </button>
                    <button v-if="selectAll" type="button" class="btn btn-info" @click="addlAllRoles">
                        تحديد الكل
                    </button>
                    <button v-else type="button" class="btn btn-info" @click="removelAllRoles">
                        الغاء الكل
                    </button>

                    <button type="submit" class="btn btn-success float-left">
                        حفظ
                    </button>
                </div>
            </div>
            <div class="card-body p-5 border-1">
                <div class="row">
                    <div class="col-6">
                        <div class="roles">
                            <ul class="tree">
                                <li :class="typeRoles ? 'has isShow' : 'has'">
                                    <i @click="typeRoles = !typeRoles" :class="typeRoles
                                        ? 'fa fa-minus'
                                        : 'fa fa-plus'
                                        "></i>
                                    <label @click="typeRoles = !typeRoles">{{ __("types") }}
                                    </label>
                                    <ul>
                                        <li>
                                            <input id="types" type="checkbox" v-model="user.types" />
                                            <label for="types">{{ __("types") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="create_type" type="checkbox" v-model="user.create_type" />
                                            <label for="create_type">
                                                {{ __("create_type") }}</label>
                                        </li>
                                        <li>
                                            <input id="edit_type" type="checkbox" v-model="user.edit_type" />
                                            <label for="edit_type">
                                                {{ __("edit_type") }}</label>
                                        </li>
                                        <li>
                                            <input id="delete_type" type="checkbox" v-model="user.delete_type" />
                                            <label for="delete_type">
                                                {{ __("delete_type") }}</label>
                                        </li>
                                        <li>
                                            <input id="type_discount" type="checkbox" v-model="user.type_discount" />
                                            <label for="type_discount">
                                                {{ __("type_discount") }}</label>
                                        </li>
                                        <li>
                                            <input id="stock" type="checkbox" v-model="user.stock" />
                                            <label for="stock">{{
                                                __("stock")
                                            }}</label>
                                        </li>
                                    </ul>
                                </li>
                                <li :class="customerRoles ? 'has isShow' : 'has'
                                        ">
                                    <label @click="customerRoles = !customerRoles">{{ __("customers") }}
                                    </label>
                                    <i @click="customerRoles = !customerRoles" :class="customerRoles
                                        ? 'fa fa-minus'
                                        : 'fa fa-plus'
                                        "></i>
                                    <ul>
                                        <li>
                                            <input id="customers" type="checkbox" v-model="user.customers" />
                                            <label for="customers">{{ __("customers") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="create_customer" type="checkbox" v-model="user.create_customer" />
                                            <label for="create_customer">
                                                {{
                                                    __("create_customer")
                                                }}</label>
                                        </li>
                                        <li>
                                            <input id="edit_customer" type="checkbox" v-model="user.edit_customer" />
                                            <label for="edit_customer">
                                                {{ __("edit_customer") }}</label>
                                        </li>
                                        <li>
                                            <input id="delete_customer" type="checkbox" v-model="user.delete_customer" />
                                            <label for="delete_customer">
                                                {{
                                                    __("delete_customer")
                                                }}</label>
                                        </li>
                                        <li>
                                            <input id="customer_pay" type="checkbox" v-model="user.customer_pay" />
                                            <label for="customer_pay">
                                                {{ __("customer_pay") }}</label>
                                        </li>
                                    </ul>
                                </li>
                                <li :class="userRoles ? 'has isShow' : 'has'">
                                    <i @click="userRoles = !userRoles" :class="userRoles
                                        ? 'fa fa-minus'
                                        : 'fa fa-plus'
                                        "></i>
                                    <label @click="userRoles = !userRoles">{{
                                        __("users")
                                    }}</label>
                                    <ul>
                                        <li>
                                            <input id="users" type="checkbox" v-model="user.users" />
                                            <label for="users">{{
                                                __("users")
                                            }}</label>
                                        </li>
                                        <li>
                                            <input id="create_user" type="checkbox" v-model="user.create_user" />
                                            <label for="create_user">
                                                {{ __("create_user") }}</label>
                                        </li>
                                        <li>
                                            <input id="edit_user" type="checkbox" v-model="user.edit_user" />
                                            <label for="edit_user">
                                                {{ __("edit_user") }}</label>
                                        </li>
                                        <li>
                                            <input id="delete_user" type="checkbox" v-model="user.delete_user" />
                                            <label for="delete_user">
                                                {{ __("delete_user") }}</label>
                                        </li>
                                        <li>
                                            <input id="user_roles" type="checkbox" v-model="user.user_roles" />
                                            <label for="user_roles">{{ __("user_roles") }}
                                            </label>
                                        </li>
                                    </ul>
                                </li>

                                <li :class="billScreen ? 'has isShow' : 'has'">
                                    <i @click="billScreen = !billScreen" :class="billScreen
                                        ? 'fa fa-minus'
                                        : 'fa fa-plus'
                                        "></i>
                                    <label @click="billScreen = !billScreen">{{
                                        __("New Bill")
                                    }}</label>
                                    <ul>
                                        <li>
                                            <input id="change_type_in_kitchen" type="checkbox" v-model="user.change_type_in_kitchen
                                                    " />
                                            <label for="change_type_in_kitchen">
                                                {{
                                                    __("change_type_in_kitchen")
                                                }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="resend" type="checkbox" v-model="user.resend" />
                                            <label for="resend">{{
                                                __("resend")
                                            }}</label>
                                        </li>
                                        <li>
                                            <input id="delete_reserved_type" type="checkbox" v-model="user.delete_reserved_type
                                                    " />
                                            <label for="delete_reserved_type">
                                                {{ __("delete_reserved_type") }}
                                            </label>
                                        </li>
                                    </ul>
                                </li>
                                <li class="single">
                                    <input id="reprint_bill" type="checkbox" v-model="user.reprint_bill" />
                                    <label for="reprint_bill">{{
                                        __("reprint_bill")
                                    }}</label>
                                </li>
                                <li class="single">
                                    <input id="delete_bill" type="checkbox" v-model="user.delete_bill" />
                                    <label for="delete_bill">{{ __("delete_bill") }}
                                    </label>
                                </li>
                                <li class="single">
                                    <input id="new_bill" type="checkbox" v-model="user.new_bill" />
                                    <label for="new_bill">{{ __("new_bill") }}
                                    </label>
                                </li>
                                <li class="single">
                                    <input id="tables" type="checkbox" v-model="user.tables" />
                                    <label for="tables">{{ __("Tables") }}
                                    </label>
                                </li>

                                <li class="single">
                                    <input id="shift" type="checkbox" v-model="user.shift" />
                                    <label for="shift">
                                        {{ __("shift") }}</label>
                                </li>
                                <li class="single">
                                    <input id="barcode_settings" type="checkbox" v-model="user.barcode_settings" />
                                    <label for="barcode_settings">
                                        {{ __("barcode_settings") }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="roles">
                            <ul class="tree">
                                <li :class="reportRoles ? 'has isShow' : 'has'">
                                    <i @click="reportRoles = !reportRoles" :class="reportRoles
                                        ? 'fa fa-minus'
                                        : 'fa fa-plus'
                                        "></i>
                                    <label @click="reportRoles = !reportRoles">{{ __("reports") }}</label>
                                    <ul>
                                        <li>
                                            <input type="checkbox" id="reports" v-model="user.reports" />
                                            <label for="reports">{{
                                                __("reports")
                                            }}</label>
                                        </li>

                                        <li>
                                            <input id="daily_report" type="checkbox" v-model="user.daily_report" />
                                            <label for="daily_report">{{ __("daily_report") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="monthly_report" type="checkbox" v-model="user.monthly_report" />
                                            <label for="monthly_report">{{ __("monthly_report") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="period_report" type="checkbox" v-model="user.period_report" />
                                            <label for="period_report">{{ __("period_report") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="bills_report" type="checkbox" v-model="user.bills_report" />
                                            <label for="bills_report">{{ __("bills_report") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="puraches_bill_report" type="checkbox" v-model="user.puraches_bill_report
                                                " />
                                            <label for="puraches_bill_report">{{
                                                __("puraches_bill_report")
                                            }}</label>
                                        </li>
                                        <li>
                                            <input id="expenses_reports" type="checkbox" v-model="user.expenses_reports" />
                                            <label for="expenses_reports">{{ __("expenses_reports") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="process_bill_report" type="checkbox" v-model="user.process_bill_report
                                                " />
                                            <label for="process_bill_report">{{ __("process_bill_report") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="shift_report" type="checkbox" v-model="user.shift_report" />
                                            <label for="shift_report">{{ __("shift_report") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="customer_pay_report" type="checkbox" v-model="user.customer_pay_report
                                                " />
                                            <label for="customer_pay_report">
                                                {{
                                                    __("customer_pay_report")
                                                }}</label>
                                        </li>
                                    </ul>
                                </li>
                                <li :class="supplierRoles ? 'has isShow' : 'has'
                                        ">
                                    <label @click="supplierRoles = !supplierRoles">{{ __("suppliers") }}
                                    </label>
                                    <i @click="supplierRoles = !supplierRoles" :class="supplierRoles
                                        ? 'fa fa-minus'
                                        : 'fa fa-plus'
                                        "></i>
                                    <ul>
                                        <li>
                                            <input id="suppliers" type="checkbox" v-model="user.suppliers" />
                                            <label for="suppliers">{{ __("suppliers") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="create_supplier" type="checkbox" v-model="user.create_supplier" />
                                            <label for="create_supplier">{{ __("create_supplier") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="edit_supplier" type="checkbox" v-model="user.edit_supplier" />
                                            <label for="edit_supplier">
                                                {{ __("edit_supplier") }}</label>
                                        </li>
                                        <li>
                                            <input id="delete_supplier" type="checkbox" v-model="user.delete_supplier" />
                                            <label for="delete_supplier">
                                                {{
                                                    __("delete_supplier")
                                                }}</label>
                                        </li>
                                    </ul>
                                </li>
                                <li :class="unitRoles ? 'has isShow' : 'has'">
                                    <label @click="unitRoles = !unitRoles">{{ __("units") }}
                                    </label>
                                    <i @click="unitRoles = !unitRoles" :class="unitRoles
                                        ? 'fa fa-minus'
                                        : 'fa fa-plus'
                                        "></i>
                                    <ul>
                                        <li>
                                            <input id="units" type="checkbox" v-model="user.units" />
                                            <label for="units">{{ __("units") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="create_unit" type="checkbox" v-model="user.create_unit" />
                                            <label for="create_unit">
                                                {{ __("create_unit") }}</label>
                                        </li>
                                        <li>
                                            <input id="edit_unit" type="checkbox" v-model="user.edit_unit" />
                                            <label for="edit_unit">
                                                {{ __("edit_unit") }}</label>
                                        </li>
                                        <li>
                                            <input id="delete_unit" type="checkbox" v-model="user.delete_unit" />
                                            <label for="delete_unit">
                                                {{ __("delete_unit") }}</label>
                                        </li>
                                    </ul>
                                </li>
                                <li :class="offerRoles ? 'has isShow' : 'has'">
                                    <label @click="offerRoles = !offerRoles">{{ __("offers") }}
                                    </label>
                                    <i @click="offerRoles = !offerRoles" :class="offerRoles
                                        ? 'fa fa-minus'
                                        : 'fa fa-plus'
                                        "></i>
                                    <ul>
                                        <li>
                                            <input id="offers" type="checkbox" v-model="user.offers" />
                                            <label for="offers">{{ __("offers") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="create_offer" type="checkbox" v-model="user.create_offer" />
                                            <label for="create_offer">
                                                {{ __("create_offer") }}</label>
                                        </li>
                                        <li>
                                            <input id="edit_offer" type="checkbox" v-model="user.edit_offer" />
                                            <label for="edit_offer">
                                                {{ __("edit_offer") }}</label>
                                        </li>
                                        <li>
                                            <input id="delete_offer" type="checkbox" v-model="user.delete_offer" />
                                            <label for="delete_offer">
                                                {{ __("delete_offer") }}</label>
                                        </li>
                                    </ul>
                                </li>
                                <li :class="main_typeRoles ? 'has isShow' : 'has'
                                    ">
                                    <label @click="
                                        main_typeRoles = !main_typeRoles
                                        ">
                                        {{ __("main_types") }}
                                    </label>
                                    <i @click="
                                        main_typeRoles = !main_typeRoles
                                        " :class="main_typeRoles
        ? 'fa fa-minus'
        : 'fa fa-plus'
        "></i>
                                    <ul>
                                        <li>
                                            <input id="main_types" type="checkbox" v-model="user.main_types" />
                                            <label for="main_types">
                                                {{ __("main_types") }}
                                            </label>
                                        </li>
                                        <li>
                                            <input id="create_main_type" type="checkbox" v-model="user.create_main_type" />
                                            <label for="create_main_type">
                                                {{
                                                    __("create_main_type")
                                                }}</label>
                                        </li>
                                        <li>
                                            <input id="edit_main_type" type="checkbox" v-model="user.edit_main_type" />
                                            <label for="edit_main_type">
                                                {{
                                                    __("edit_main_type")
                                                }}</label>
                                        </li>
                                        <li>
                                            <input id="delete_main_type" type="checkbox" v-model="user.delete_main_type" />
                                            <label for="delete_main_type">
                                                {{
                                                    __("delete_main_type")
                                                }}</label>
                                        </li>
                                    </ul>
                                </li>

                                <li class="single">
                                    <input id="print_barcode" type="checkbox" v-model="user.print_barcode" />
                                    <label for="print_barcode">
                                        {{ __("print_barcode") }}
                                    </label>
                                </li>
                                <li class="single">
                                    <input id="settings" type="checkbox" v-model="user.settings" />
                                    <label for="settings">{{ __("settings") }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";

export default {
    components: { Spinner },

    async created() {
        if (!User.loggedIn()) {
            await this.$router.push({ name: "/" });
        }

        this.userRole = await Auth.getAuth();
        let id = this.$route.params.id;
        await axios
            .get("/api/usersRole/" + id)
            .then(({ data }) => {
                this.user = data;
            })
            .catch((error) => console.log(error));
    },
    data() {
        return {
            userRole: {},
            permission: "Permission",
            selectAll: true,
            user: {
                period_report: false,
                bill_details: false,
                bills: false,
                new_bill: false,
                tables: false,

                puraches_bill: false,
                expenses: false,
                puraches_bills: false,
                customers: false,
                delete_customer: false,
                edit_customer: false,
                create_customer: false,
                users: false,
                delete_user: false,
                edit_user: false,
                create_user: false,
                user_roles: false,
                change_price: false,
                types: false,
                create_type: false,
                delete_type: false,
                edit_type: false,
                reports: false,
                daily_report: false,
                monthly_report: false,
                bills_report: false,
                puraches_bill_report: false,
                expenses_reports: false,
                process_bill: false,
                process_bill_report: false,
                stock: false,
                pay_bill: false,
                remove_from_cart: false,
                bill_discount: false,
                type_discount: false,
                bill_extra: false,
                shift: false,
                shift_report: false,
                customer_pay: false,
                customer_pay_report: false,
                suppliers: false,
                supplier_report: false,
                create_supplier: false,
                edit_supplier: false,
                delete_supplier: false,
                settings: false,
                units: false,
                edit_unit: false,
                delete_unit: false,
                create_unit: false,
                main_types: false,
                edit_main_type: false,
                delete_main_type: false,
                create_main_type: false,
                offers: false,
                edit_offer: false,
                delete_offer: false,
                create_offer: false,
                barcode_settings: false,
                print_barcode: false,
                reprint_bill: false,
            },
            typeRoles: false,
            billRoles: false,
            customerRoles: false,
            userRoles: false,
            billScreen: false,
            reportRoles: false,
            supplierRoles: false,
            unitRoles: false,
            main_typeRoles: false,
            offerRoles: false,
            showAll: false,
        };
    },
    methods: {
        fadeIn() {
            this.showAll = true;
            this.typeRoles = true;
            this.billRoles = true;
            this.customerRoles = true;
            this.userRoles = true;
            this.billScreen = true;

            this.reportRoles = true;
            this.supplierRoles = true;
            this.unitRoles = true;
            this.main_typeRoles = true;
            this.offerRoles = true;
        },
        fadeOut() {
            this.showAll = false;
            this.typeRoles = false;
            this.billRoles = false;
            this.customerRoles = false;
            this.userRoles = false;
            this.billScreen = false;

            this.reportRoles = false;
            this.supplierRoles = false;
            this.unitRoles = false;
            this.main_typeRoles = false;
            this.offerRoles = false;
        },
        update() {
            let id = this.$route.params.id;
            axios
                .patch("/api/usersRole/" + id, this.user)
                .then(() => {
                    Notification.success();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        addlAllRoles() {
            this.selectAll = false;
            this.user.units = true;
            this.user.edit_unit = true;
            this.user.delete_unit = true;
            this.user.create_unit = true;
            this.user.main_types = true;
            this.user.edit_main_type = true;
            this.user.delete_main_type = true;
            this.user.create_main_type = true;
            this.user.offers = true;
            this.user.edit_offer = true;
            this.user.delete_offer = true;
            this.user.create_offer = true;
            this.user.barcode_settings = true;
            this.user.print_barcode = true;
            this.user.reprint_bill = true;
            this.user.period_report = true;
            this.user.bill_details = true;
            this.user.bills = true;
            this.user.new_bill = true;
            this.user.tables = true;

            this.user.puraches_bill = true;
            this.user.expenses = true;
            this.user.puraches_bills = true;
            this.user.customers = true;
            this.user.delete_customer = true;
            this.user.edit_customer = true;
            this.user.create_customer = true;
            this.user.users = true;
            this.user.delete_user = true;
            this.user.edit_user = true;
            this.user.create_user = true;
            this.user.user_roles = true;
            this.user.change_price = true;
            this.user.types = true;
            this.user.create_type = true;
            this.user.delete_type = true;
            this.user.edit_type = true;
            this.user.reports = true;
            this.user.daily_report = true;
            this.user.monthly_report = true;
            this.user.bills_report = true;
            this.user.puraches_bill_report = true;
            this.user.expenses_reports = true;
            this.user.process_bill = true;
            this.user.process_bill_report = true;
            this.user.stock = true;
            this.user.pay_bill = true;
            this.user.remove_from_cart = true;
            this.user.bill_discount = true;
            this.user.type_discount = true;
            this.user.bill_extra = true;
            this.user.shift = true;
            this.user.shift_report = true;
            this.user.customer_pay = true;
            this.user.customer_pay_report = true;
            this.user.suppliers = true;
            this.user.supplier_report = true;
            this.user.create_supplier = true;
            this.user.edit_supplier = true;
            this.user.delete_supplier = true;
            this.user.settings = true;
            this.user.change_type_in_kitchen = true;
            this.user.resend = true;
            this.user.delete_reserved_type = true;
            this.user.delete_bill = true;
        },
        removelAllRoles() {
            this.selectAll = true;
            this.user.units = false;
            this.user.edit_unit = false;
            this.user.delete_unit = false;
            this.user.create_unit = false;
            this.user.main_types = false;
            this.user.edit_main_type = false;
            this.user.delete_main_type = false;
            this.user.create_main_type = false;
            this.user.offers = false;
            this.user.edit_offer = false;
            this.user.delete_offer = false;
            this.user.create_offer = false;
            this.user.barcode_settings = false;
            this.user.print_barcode = false;
            this.user.reprint_bill = false;
            this.user.period_report = false;
            this.user.bill_details = false;
            this.user.bills = false;
            this.user.new_bill = false;
            this.user.tables = false;

            this.user.puraches_bill = false;
            this.user.expenses = false;
            this.user.puraches_bills = false;
            this.user.customers = false;
            this.user.delete_customer = false;
            this.user.edit_customer = false;
            this.user.create_customer = false;
            this.user.users = false;
            this.user.delete_user = false;
            this.user.edit_user = false;
            this.user.create_user = false;
            this.user.user_roles = false;
            this.user.change_price = false;
            this.user.types = false;
            this.user.create_type = false;
            this.user.delete_type = false;
            this.user.edit_type = false;
            this.user.reports = false;
            this.user.daily_report = false;
            this.user.monthly_report = false;
            this.user.bills_report = false;
            this.user.puraches_bill_report = false;
            this.user.expenses_reports = false;
            this.user.process_bill = false;
            this.user.process_bill_report = false;
            this.user.stock = false;
            this.user.pay_bill = false;
            this.user.remove_from_cart = false;
            this.user.bill_discount = false;
            this.user.type_discount = false;
            this.user.bill_extra = false;
            this.user.shift = false;
            this.user.shift_report = false;
            this.user.customer_pay = false;
            this.user.customer_pay_report = false;
            this.user.suppliers = false;
            this.user.supplier_report = false;
            this.user.create_supplier = false;
            this.user.edit_supplier = false;
            this.user.delete_supplier = false;
            this.user.settings = false;
            this.user.change_type_in_kitchen = false;
            this.user.resend = false;
            this.user.delete_reserved_type = false;
            this.user.delete_bill = false;
        },
        isTrue(val) {
            if (val == 1) {
                return true;
            }
            return false;
        },
    },
};
</script>

<style scoped>
.isShow ul {
    display: block !important;
}

*:not(i) {
    padding: 0px;
    margin: 0px;
    outline: none;
    font: 16px "Calibri";
    font-weight: bold;
    list-style-type: none;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.roles {
    padding: 10px;
    border: 1px solid #ddd;
    margin: 5px;
    border-radius: 15px;
}

.tree ul li:hover,
.single:hover {
    background: darkmagenta;
    transition: 0.5s ease-in-out;
    color: #fff;
    font-weight: bolder;
}

.controls {
    top: 0;
    left: 0;
    right: 0;
    background: #fff;
    z-index: 1;
    padding: 6px 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    margin: auto;
}

button {
    border: 0px;
    margin: 4px;
    padding: 4px 12px;
    cursor: pointer;
}

button:hover {
    background: #efefef;
}

input[type="checkbox"] {
    vertical-align: middle !important;
}

.tree {
    margin: 2% auto;
}

.tree ul {
    display: none;
    margin: 4px auto;
    margin-left: 6px;
    border-left: 1px dashed #dfdfdf;
}

.tree li {
    padding: 12px 18px;
    cursor: pointer;
    vertical-align: middle;
    background: #fff;
}

.tree li:first-child {
    border-radius: 3px 3px 0 0;
}

.tree li:last-child {
    border-radius: 0 0 3px 3px;
}

.tree .active,
.active li {
    background: #efefef;
}

.tree label {
    cursor: pointer;
}

.tree input[type="checkbox"] {
    margin: -2px 6px 0 0px;
}
</style>
