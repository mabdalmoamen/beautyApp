<template>
    <div class="col-12">
            <!--        Search -->
            <div
                aria-hidden="true"
                aria-labelledby="exampleModalLabel"
                :class="
                    showSearchTypeModal
                        ? 'modal fade show d-block modaldrg'
                        : 'modal fade modaldrg'
                "
                role="dialog"
                tabindex="-1"
            >
                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document"
                >
                    <div class="modal-content m-auto" style="min-width: 850px">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ bill.bill_total }}</h5>
                            <button
                                aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button"
                            >
                                <span
                                    aria-hidden="true"
                                    @click="
                                        searchTypes = [];
                                        typeName = '';
                                        showSearchTypeModal = false;
                                    "
                                    >&times;</span
                                >
                            </button>
                        </div>
                        <div
                            class="modal-body min-h-50"
                            style="min-height: 500px; overflow: auto"
                        >
                            <input
                                v-model="typeName"
                                class="form-control-sm"
                                :placeholder="__('Type Name')"
                                type="search"
                                @keyup="findTypeByLike()"
                            />
                            <button
                                class="btn btn-sm btn-info"
                                @click="findTypeByLike()"
                            >
                                <i
                                    class="fa fa-search font-weight-bold text-light"
                                ></i>
                            </button>
                            <table
                                style="
                                    position: absolute;
                                    z-index: 999;
                                    overflow: auto;
                                "
                                class="text-center"
                            >
                                <thead>
                                    <tr>
                                        <th style="width: 10%">
                                            {{ __("Code") }}
                                        </th>
                                        <th style="width: 50%">
                                            {{ __("Type Name") }}
                                        </th>

                                        <th style="width: 10%">
                                            {{ __("Price") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Select") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(
                                            searchType, index
                                        ) in searchTypes"
                                        :key="index"
                                    >
                                        <td>{{ searchType.type_id }}</td>
                                        <td>{{ searchType.type_name_ar }}</td>
                                        <td>{{ searchType.type_price }}</td>
                                        <td>
                                            <i
                                                class="fa fa-plus btn-sm btn-success font-weight-bold text-light"
                                                @click="addToCart(searchType)"
                                            ></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-secondary"
                                data-dismiss="modal"
                                @click="
                                    searchTypes = [];
                                    typeName = '';
                                    showSearchTypeModal = false;
                                "
                                type="button"
                            >
                                {{ __("Close") }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--   END     Search -->
            <!--Start Calculation-->

            <div class="card-header">
                <form class="w-100" direction="rtl" @submit.prevent="saveBill">
                    <table
                        class="table-bordered text-lighten-1 text-center font-weight-bold"
                    >
                        <tbody>
                            <tr>
                                <td style="width: 10%">
                                    {{ __("Supplier Code") }}
                                </td>
                                <td style="width: 10%">
                                    <input
                                        v-model="search"
                                        class="form-control-sm"
                                        type="text"
                                        @keyup="findSupplier"
                                    />
                                </td>
                                <td style="width: 10%">
                                    {{ __("Supplier Name") }}
                                </td>
                                <td style="width: 10%">
                                    <input
                                        :value="supplier.supplier_name"
                                        class="form-control-sm"
                                        placeholder=""
                                        type="text"
                                    />
                                </td>
                                <td style="width: 10%">
                                    <a
                                        :title="supplier.supplier_total_remain"
                                        class="btn btn-info btn-sm text-light"
                                        data-target="#exampleModal"
                                        data-toggle="modal"
                                        ><i
                                            class="fas fa-search font-weight-bold text-light"
                                        ></i
                                    ></a>
                                </td>
                                <td style="width: 10%">
                                    {{ __("Pay Method") }}
                                </td>
                                <td style="width: 10%">
                                    <select
                                        v-model="form.pay"
                                        @change="calcTotal()"
                                        class="form-control float-left text-center"
                                    >
                                        <option
                                            v-for="(pay, index) in payMethods"
                                            :value="pay.id"
                                            :key="index"
                                        >
                                            {{ pay.pay_method_name }}
                                        </option>
                                    </select>
                                </td>

                                <td style="width: 10%">{{ __("Paid") }}</td>
                                <td style="width: 10%">
                                    <input
                                        v-model="form.paid"
                                        class="form-control float-left text-center"
                                        @keyup="calcRemain()"
                                    />
                                </td>
                                <td>{{ __("Remain") }}</td>
                                <td style="width: 10%">
                                    <input
                                        readonly
                                        v-model="form.remain"
                                        class="form-control float-left text-center"
                                    />
                                </td>
                                <td style="width: 10%">
                                    <button
                                        :disabled="
                                            form.total <= 0 || cart.length <= 0
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
                                <td style="width: 10%">
                                    {{ __("BillSerial") }}
                                </td>
                                <td style="width: 10%">
                                    <input
                                        required
                                        r
                                        v-model="form.bill_serial"
                                        class="form-control-sm float-left text-center"
                                    />
                                </td>
                                <td style="width: 10%">{{ __("Sum") }}</td>
                                <td style="width: 10%">
                                    <input
                                        readonly
                                        v-model="form.sum"
                                        class="form-control float-left text-center"
                                    />
                                </td>
                                <td
                                    style="width: 10%"
                                    v-show="user.bill_discount"
                                >
                                    الخصم:{{}}
                                </td>

                                <td
                                    style="width: 10%"
                                    v-show="user.bill_discount"
                                >
                                    <input
                                        v-model="form.discount"
                                        class="form-control float-left text-center"
                                        @keyup="calcTotal()"
                                    />
                                </td>
                                <td>{{ __("Extra") }}</td>

                                <td style="width: 10%">
                                    <input
                                        v-model="form.extra"
                                        class="form-control float-left text-center"
                                        @keyup="calcTotal()"
                                    />
                                </td>
                                <td>{{ __("Vat") }}</td>

                                <td style="width: 10%">
                                    <input
                                        readonly
                                        v-model="form.vat"
                                        class="form-control float-left text-center"
                                    />
                                </td>
                                <td class="form-control">{{ __("Total") }}</td>

                                <td style="width: 10%">
                                    <input
                                        readonly
                                        v-model="form.total"
                                        class="form-control float-left text-center"
                                    />
                                </td>

                                <td style="width: 100%">
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

                <div>
                    <input
                        v-model="barcode"
                        autofocus
                        class="form-control-sm"
                        :placeholder="__('Barcode')"
                        type="search"
                        @change="findType()"
                    />

                    <input
                        v-model="id"
                        class="form-control-sm"
                        :placeholder="__('Simple Code')"
                        type="search"
                        @change="findTypeByCodeOrId()"
                    />
                    <button
                        class="btn btn-sm btn-info"
                        @click="showSearchTypeModal = true"
                    >
                        <i class="fa fa-search font-weight-bold text-light"></i>
                    </button>
                </div>
            </div>
            <!--Start Calculation-->
            <div class="mb-3 newBill">
                <!-- Selected Items-->
                <div class="col-md-112">
                    <div class="selected text-center w-100">
                        <div style="min-height: 50vh">
                            <table class="text-center">
                                <thead>
                                    <tr>
                                        <th
                                            class="col-header"
                                            style="width: 50%"
                                        >
                                            {{ __("Type Name") }}
                                        </th>
                                        <th
                                            class="col-header"
                                            style="width: 30%"
                                        >
                                            {{ __("Count") }}
                                        </th>
                                        <th
                                            style="width: 10%"
                                            v-show="mixins.use_type_uints"
                                        >
                                            {{ __("Unit") }}
                                        </th>

                                        <th
                                            class="col-header"
                                            style="width: 10%"
                                        >
                                            {{ __("Price") }}
                                        </th>
                                        <th
                                            class="col-header"
                                            style="width: 10%"
                                        >
                                            {{ __("Total") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="cart.length > 0">
                                    <tr
                                        v-for="(product, index) in cart"
                                        :key="index"
                                    >
                                        <td class="font-weight-bold">
                                            {{ product.type_name_ar }}
                                        </td>
                                        <td>
                                            <a
                                                v-if="product.type_count === 1"
                                                class="btn mx-2 btn-danger"
                                                @click="
                                                    removeFromCart(
                                                        product,
                                                        index
                                                    )
                                                "
                                                ><i
                                                    class="fa fa-trash text-light"
                                                ></i>
                                            </a>
                                            <a
                                                v-else
                                                class="btn mx-2 btn-warning"
                                                @click="decrement(product)"
                                                >-</a
                                            >
                                            <input
                                                v-model="product.type_count"
                                                class="btn"
                                                min="0"
                                                type="number"
                                                style="width: 80px"
                                                @change="
                                                    calcTotalTypeCost(product)
                                                "
                                            />

                                            <a
                                                class="btn mx-2 btn-success"
                                                @click="increment(product)"
                                                >+</a
                                            >
                                        </td>
                                        <td v-if="mixins.use_type_uints">
                                            <select
                                                v-if="product.sell_unit"
                                                v-model="product.sell_unit"
                                                class="form-control-sm"
                                                @change="
                                                    calcTotalTypeCost(product)
                                                "
                                            >
                                                <option
                                                    v-for="(
                                                        unit, index
                                                    ) in product.units"
                                                    :key="index"
                                                    :selected="
                                                        unit ===
                                                        product.sell_unit.unit
                                                    "
                                                    :value="unit"
                                                >
                                                    {{ unit.unit.unit_ar_name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input
                                                class="btn text-bold"
                                                style="width: 100px"
                                                v-model="product.type_price"
                                                @keyup="calcSum(product)"
                                            />
                                        </td>
                                        <td>
                                            <b class="btn text-bold">{{
                                                format(
                                                    product.total_purchase_price
                                                )
                                            }}</b>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr class="w-100">
                                        <td
                                            colspan="5"
                                            class="m-auto font-weight-light"
                                        >
                                            لا توجد أصناف
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  All Products -->
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
                        <div
                            class="modal-content m-auto"
                            style="min-width: 850px"
                        >
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">
                                    {{ bill.bill_total }}
                                </h5>
                                <button
                                    aria-label="Close"
                                    class="close"
                                    data-dismiss="modal"
                                    type="button"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
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
                                        <table
                                            class="table align-items-center table-flush"
                                        >
                                            <thead class="thead-light">
                                                <tr>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{
                                                            __("Supplier Code")
                                                        }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 30%"
                                                    >
                                                        {{
                                                            __("Supplier Name")
                                                        }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 30%"
                                                    >
                                                        {{
                                                            __(
                                                                "Supplier Mobile"
                                                            )
                                                        }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
                                                        {{
                                                            __(
                                                                "Supplier Balance"
                                                            )
                                                        }}
                                                    </th>
                                                    <th
                                                        class="col-header"
                                                        style="width: 10%"
                                                    >
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
                                                        {{
                                                            supplier.supplier_id
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            supplier.supplier_name
                                                        }}
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
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div></div>
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";

export default {
    components: { Spinner },

    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
                this.user = await Auth.getAuth();
        this.mixins = this.user.branch;

        await this.allProducts();
        await this.allSuppliers();
        await this.allPayMethods();
    },
    data() {
        return {
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

    computed: {
        filterSearch() {
            return this.suppliers.filter((supp) => {
                return supp.supplier_name.match(this.searchTerm);
            });
        },
    },

    methods: {

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
        findType() {
            axios
                .get("/api/findTypeByBarcode/" + this.barcode)
                .then(({ data }) => {
                    this.type = data;
                    if (data.type_id != null) {
                        this.addToCart(data);
                        this.barcode = "";
                    } else {
                        Notification.customMsg(
                            "warning",
                            "topRight",
                            "لايوجد صنف بهذا الاسم"
                        );
                    }
                })
                .catch((error) => console.log(error));
        },
        findTypeByCodeOrId() {
            axios
                .get("/api/action/find/" + this.id)
                .then(({ data }) => {
                    this.type = data;
                    if (data.type_id != null) {
                        this.addToCart(data);
                        this.id = "";
                    } else {
                        Notification.customMsg(
                            "warning",
                            "topRight",
                            "لايوجد صنف بهذا الاسم"
                        );
                    }
                })
                .catch((error) => console.log(error));
        },
        onChangeCount(product) {
            if (product.type_count <= 1) {
                product.type_count = 1;
            }
            this.calcTotalTypeCost(product);
        },
        onChangeTypeCost(product) {
            this.calcTotalTypeCost(product);
        },
        findTypeByLike() {
            axios
                .get("/api/action/like/" + this.typeName)
                .then(({ data }) => {
                    this.searchTypes = data;
                })
                .catch((error) => console.log(error));
        },
        selectSupplier(supplier) {
            this.supplier = supplier;
            this.search = supplier.supplier_id;
        },

        async addToCart(product) {
            if (this.cart.includes(product)) {
                product.type_count++;
            } else {
                product.type_count = 1;
                this.cart.push(product);
            }
            await this.calcTotalTypeCost(product);
        },
        async removeFromCart(product, index) {
            product.type_count = 1;
            product.total_purchase_price =
                product.type_count * parseFloat(product.type_price);
            await this.$delete(this.cart, index);
            await this.calcSum();
        },
        async increment(product) {
            product.type_count++;
            await this.calcTotalTypeCost(product);
        },
        async decrement(product) {
            product.type_count--;
            await this.calcTotalTypeCost(product);
        },
        async findUnit(product) {
            await axios
                .get("/api/units/" + product.sell_unit)
                .then(({ data }) => {
                    this.typeUnit = data;
                })
                .catch((error) => console.log(error));
        },
        async calcUnitPrice(product) {
            if (product.sell_unit !== null) {
                product.type_sill_price =
                    product.sell_unit.price ?? product.type_sill_price;
                if (product.type_stock !== null) {
                    if (product.type_stock.mixins_type_stock > 0) {
                        var totalNofUnit =
                            product.sell_unit.no_of_unit *
                                product.type_stock.mixins_type_stock -
                            product.type_count;
                        product.calc_count =
                            totalNofUnit / product.sell_unit.no_of_unit;
                    }
                }
            }
        },
        async calcUnitPrice(product) {
            if (product.sell_unit !== null) {
                product.type_price =
                    product.sell_unit.price ??
                    product.type_purchases_price /
                        product.sell_unit.no_of_unit ??
                    product.type_purchases_price;

                if (product.type_stock !== null) {
                    var totalNofUnit =
                        product.sell_unit.no_of_unit *
                            product.type_stock.mixins_type_stock +
                        product.type_count;
                    product.calc_count =
                        totalNofUnit / product.sell_unit.no_of_unit;
                }

                if (
                    product.type_price === "NaN" ||
                    product.type_price <= 0 ||
                    !product.type_price
                ) {
                    product.type_price = product.type_purchases_price;
                }
            } else {
                product.type_price = product.type_purchases_price;
            }
        },
        async calcTotalTypeCost(product) {
            if (this.mixins.use_type_uints) {
                await this.calcUnitPrice(product);
            } else {
                product.type_price = product.type_purchases_price;
            }
            if (product.type_price > 0) {
                product.total_purchase_price =
                    product.type_count * parseFloat(product.type_price);
            } else {
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن ان سكون سعر الشراء بصفر"
                );
            }
            await this.calcSum();
        },
        format(num) {
            return parseFloat(num).toFixed(this.mixins.digit);
        },
        async calcSum() {
            this.form.sum = 0;
            this.cart.filter((product) => {
                product.total_purchase_price =
                    product.type_count * parseFloat(product.type_price);

                this.form.sum =
                    parseFloat(this.form.sum) +
                    parseFloat(product.total_purchase_price);
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
            if (this.cart.length <= 0) {
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
            this.form.cart = this.cart;
            this.form.supplier = this.supplier;
            await axios
                .post("api/purchases", this.form)
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
        clearAll() {
            this.cart = [];
            this.form.cart = [];
            this.supplier = {};
            this.search = "";
            this.calcSum();
        },
    },
};
</script>
