<template>
    <div>
        <!-- Datatables -->
        <div v-if="!loading">
            <div
                id="exampleModal"
                aria-hidden="true"
                aria-labelledby="exampleModalLabel"
                class="modal fade"
                role="dialog"
                tabindex="-1"
            >
                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document"
                >
                    <div class="modal-content m-auto" style="min-width: 850px">

                        <div class="modal-body">
                            <div class="col-lg-12 mb-4">
                                <div class="table-responsive w-100">
                                    <label
                                        >Search:<input
                                            v-model="searchName"
                                            aria-controls="dataTable"
                                            class="form-control form-control-sm"
                                            placeholder=""
                                            type="search"
                                    /></label>
                                    <table class="table align-items-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>
                                                    {{ __("Supplier Code") }}
                                                </th>
                                                <th style="width: 30%">
                                                    {{ __("Supplier Name") }}
                                                </th>
                                                <th style="width: 30%">
                                                    {{ __("Supplier Mobile") }}
                                                </th>
                                                <th>
                                                    {{ __("Supplier Balance") }}
                                                </th>
                                                <th>
                                                    {{ __("Select") }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    supplier, index
                                                ) in suppliers"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ supplier.supplier_id }}
                                                </td>
                                                <td>
                                                    {{ supplier.supplier_name }}
                                                </td>
                                                <td>
                                                    {{
                                                        supplier.supplier_mobile
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        supplier.supplier_total_remain
                                                    }}
                                                </td>

                                                <td>
                                                    <button
                                                        class="btn btn-success btn-sm"
                                                        data-dismiss="modal"
                                                        @click="
                                                            selectSupplier(
                                                                supplier
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-plus"
                                                        ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-secondary"
                                data-dismiss="modal"
                                type="button"
                            >
                                {{__('Close')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
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

                    <form
                        class="w-100"
                        direction="rtl"
                        @submit.prevent="saveBill"
                    >
                        <table
                            class="table-bordered text-lighten-1 text-center font-weight-bold"
                        >
                            <tbody>
                                <tr>
                                    <td>
                                        {{ __("Supplier Code") }}
                                    </td>
                                    <td>
                                        <input
                                            v-model="search"
                                            class="form-control-sm"
                                            type="text"
                                            @keyup="findSupplier"
                                        />
                                    </td>
                                    <td>
                                        {{ __("Supplier Name") }}
                                    </td>
                                    <td>
                                        <input
                                            :value="supplier.supplier_name"
                                            class="form-control-sm"
                                            placeholder=""
                                            type="text"
                                        />
                                    </td>
                                    <td>
                                        <a
                                            :title="
                                                supplier.supplier_total_remain
                                            "
                                            class="btn btn-info btn-sm text-light"
                                            data-target="#exampleModal"
                                            data-toggle="modal"
                                            ><i
                                                class="fas fa-search font-weight-bold text-light"
                                            ></i
                                        ></a>
                                    </td>
                                    <td>
                                        {{ __("Pay Method") }}
                                    </td>
                                    <td>
                                        <select
                                            v-model="form.pay"
                                            @change="calcTotal()"
                                            class="form-control text-center"
                                        >
                                            <option
                                                v-for="(
                                                    pay, index
                                                ) in payMethods"
                                                :value="pay.id"
                                                :key="index"
                                            >
                                                {{ pay.pay_method_name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        {{ __("BillSerial") }}
                                    </td>
                                    <td>
                                        <input
                                            required
                                            v-model="form.bill_serial"
                                            class="form-control-sm text-center"
                                        />
                                    </td>
                                    <td>
                                        <button
                                            :disabled="
                                                form.total <= 0 ||
                                                form.cart.length <= 0
                                            "
                                            class="btn btn-outline-success font-weight-bold text-dark"
                                            type="submit"
                                        >
                                            {{ __("Save") }}
                                        </button>
                                    </td>
                                    <td>
                                        <a
                                            class="btn font-weight-bold btn-outline-warning text-dark"
                                            @click="clearAll()"
                                            >{{ __("Reset") }}</a
                                        >
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        {{ __("Paid") }}
                                    </td>
                                    <td>
                                        <input
                                            v-model="form.paid"
                                            class="form-control text-center"
                                            @keyup="calcRemain()"
                                        />
                                    </td>
                                    <td>{{ __("Remain") }}</td>
                                    <td>
                                        <input
                                            readonly
                                            v-model="form.remain"
                                            class="form-control text-center"
                                        />
                                    </td>

                                    <td>
                                        {{ __("Sum") }}
                                    </td>
                                    <td>
                                        <input
                                            readonly
                                            v-model="form.sum"
                                            class="form-control text-center"
                                        />
                                    </td>
                                    <td
                                        class="d-none"
                                        v-show="user.bill_discount"
                                    >
                                        الخصم:{{}}
                                    </td>

                                    <td
                                        class="d-none"
                                        v-show="user.bill_discount"
                                    >
                                        <input
                                            v-model="form.discount"
                                            class="form-control text-center"
                                            @keyup="calcTotal()"
                                        />
                                    </td>
                                    <td class="d-none">
                                        {{ __("Extra") }}
                                    </td>

                                    <td class="d-none">
                                        <input
                                            v-model="form.extra"
                                            class="form-control text-center"
                                            @keyup="calcTotal()"
                                        />
                                    </td>
                                    <td class="d-none">{{ __("Vat") }}</td>

                                    <td class="d-none">
                                        <input
                                            readonly
                                            v-model="form.vat"
                                            class="form-control text-center"
                                        />
                                    </td>
                                    <td class="form-control">
                                        {{ __("Total") }}
                                    </td>

                                    <td>
                                        <input
                                            readonly
                                            v-model="form.total"
                                            class="form-control text-center"
                                        />
                                    </td>

                                    <td>
                                        <input
                                            v-model="form.note"
                                            class="form-control-sm"
                                            :placeholder="__('Notes')"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>

                <div class="card-body px-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <div
                                class="card-header py-0 d-flex flex-row align-items-center justify-content-between"
                            >
                                <p>{{ __("Bill Types") }}</p>
                            </div>
                            <table class="text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('Stock Name')}}</th>
                                        <th>{{__('Count')}}</th>
                                        <th>{{__('Cost')}}</th>
                                        <th>{{__('Total')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-if="form.cart.length > 0"
                                        v-for="(stock, index) in form.cart"
                                        :key="index"
                                    >
                                        <td>{{ stock.title }}</td>
                                        <td style="width: 80px">
                                            <a
                                                v-if="stock.type_count <= 1"
                                                class="btn mx-2 btn-danger"
                                                @click="
                                                    removeFromCart(stock, index)
                                                "
                                                ><i
                                                    class="fa fa-trash text-light"
                                                ></i>
                                            </a>
                                            <button
                                                v-else
                                                class="btn mx-2 btn-warning"
                                                @click="decrement(stock)"
                                            >
                                                -
                                            </button>
                                            <input
                                                v-model="stock.type_count"
                                                class="btn text-bold"
                                                style="width: 80px"
                                                onClick="this.select();"
                                                min="0"
                                                step="0.01"
                                                type="number"
                                                @change="calcSum()"
                                            />
                                            <button
                                                class="btn mx-2 btn-success"
                                                @click="increment(stock)"
                                            >
                                                +
                                            </button>
                                        </td>
                                        <td>
                                            <input
                                                v-model="stock.type_price"
                                                class="btn text-bold"
                                                style="width: 80px"
                                                onClick="this.select();"
                                                min="0"
                                                step="0.01"
                                                type="number"
                                                @change="calcSum()"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                readonly
                                                v-model="
                                                    stock.total_purchase_price
                                                "
                                                class="btn text-bold"
                                                style="width: 80px"
                                                onClick="this.select();"
                                                min="0"
                                                step="0.01"
                                                type="number"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <div
                                class="card-header py-0 d-flex flex-row align-items-center justify-content-between"
                            >
                                <p>{{ __("Stock") }}</p>
                            </div>
                            <div class="row text-center">
                                <div
                                    class="col-3"
                                    v-for="(stock, index) in stocks"
                                    :key="index"
                                    @click="addToCart(stock)"
                                >
                                    <div
                                        class="card pointer btn-app mb-3 p-3 bg-success"
                                    >
                                        <span
                                            class="badge badge-warning text-light"
                                        >
                                            {{ stock.stock }}
                                        </span>
                                        <div class="card-body">
                                            {{ stock.title }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- DataTable with Hover -->
    </div>
</template>

<script>
export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        await this.allSuppliers();
        await this.allPayMethods();
        this.user = await Auth.getAuth();
        this.form.branch_id = this.user.branch_id;
        this.mixins = this.user.branch;

        this.allStocks();
    },
    data() {
        return {
            title: "Stocks",
            stocks: [],
            searchTerm: "",
            loading: true,
            user: {},
            searchTypes: [],
            showSearchTypeModal: false,
            typeName: "",
            id: "",
            output: null,
            products: [],
            categories: [],
            category: {},
            suppliers: [],
            supplier: {},
            payMethods: [],
            search: "",
            barcode: "",
            searchName: "",
            type: {},
            bill_id: 0,
            bill: {},
            cart: [],
            form: {
                user_id: null,
                note: "",
                sum: 0.0,
                discount: 0.0,
                total: 0.0,
                extra: 0.0,
                vat: 0.0,
                cart: [],
                paid: 0.0,
                remain: 0.0,
                pay: 1,
                supplier: {},
            },
            errors: {},
            mixins: {},
        };
    },

    methods: {
        allStocks() {
            axios
                .get("/api/stocks")
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.loading = false;
                        this.stocks = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        allProducts() {
            axios
                .get("/api/types")
                .then(({ data }) => (this.products = data))
                .catch((error) => console.log(error));
        },
        allSuppliers() {
            axios
                .get("/api/suppliers")
                .then(({ data }) => (this.suppliers = data))
                .catch((error) => console.log(error));
        },
        allPayMethods() {
            axios
                .get("/api/payMethods")
                .then(({ data }) => (this.payMethods = data))
                .catch((error) => console.log(error));
        },
        findSupplier() {
            axios
                .get("/api/suppliers/" + this.search)
                .then(({ data }) => (this.supplier = data))
                .catch((error) => console.log(error));
        },
        selectSupplier(supplier) {
            this.supplier = supplier;
            this.search = supplier.supplier_id;
        },
        async addToCart(stock) {
            let cloneStock = await JSON.parse(JSON.stringify(stock));
            cloneStock.type_count = 1;
            cloneStock.type_price = stock.type_price ?? 0;
            this.form.cart.push(cloneStock);
            await this.calcSum(cloneStock);
        },
        async removeFromCart(stock, index) {
            stock.type_count = 1;
            stock.total_purchase_price =
                stock.type_count * parseFloat(stock.type_price);
            this.$delete(this.form.cart, index);
            await this.calcSum();
        },
        async increment(stock) {
            stock.type_count++;
            await this.calcSum(stock);
        },
        async decrement(stock) {
            if (stock.type_count <= 1) {
                stock.type_count = 1;
            } else {
                stock.type_count--;
            }
            await this.calcSum(stock);
        },
        async calcSum() {
            this.form.sum = 0;
            this.form.cart.filter((stock) => {
                stock.total_purchase_price = stock.type_price ?? 0.0;
                stock.total_purchase_price =
                    stock.type_count * parseFloat(stock.type_price);

                this.form.sum =
                    parseFloat(this.form.sum) +
                    parseFloat(stock.total_purchase_price);
            });
            await this.calcTotal();
        },
        calcTotal() {
            this.form.total = 0;
            let vatVal = localStorage.getItem("vat");
            this.form.total = parseFloat(
                Number(
                    Number(this.form.sum) +
                        Number(this.form.extra) -
                        Number(this.form.discount)
                )
            );
            //Form number
            this.form.sum = this.format(this.form.sum);
            this.form.total = this.format(this.form.total);
            this.form.paid = this.form.total;
        },
        calcRemain() {
            this.form.remain = this.form.total - this.form.paid;
            this.form.remain = parseFloat(this.form.remain);
        },
        async saveBill() {
            let isValid = true;
            if (this.form.cart.length <= 0) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن حفظ فاتورة بدون أصناف"
                );
                return;
            }
            if (this.form.total <= 0) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن حفظ فاتورة قيمتها صفر"
                );
                return;
            }
            if (isValid) await this.saveValidBill();
        },
        async saveValidBill() {
            this.form.user_id = localStorage.getItem("user_id");
            this.form.supplier = this.supplier;
            await axios
                .post("/api/purchases", this.form)
                .then(async (data) => {
                    Notification.success();
                    await this.clearAll();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .then((e) => {
                    if (this.errors.supplier)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.supplier[0]
                        );
                    if (this.errors.bill_serial)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.bill_serial[0]
                        );
                });
        },
        format(num) {
            return parseFloat(num).toFixed(this.mixins.digit);
        },
        clearAll() {
            this.form.cart = [];
            this.supplier = {};
            this.search = "";
            this.calcSum();
        },
    },
};
</script>
