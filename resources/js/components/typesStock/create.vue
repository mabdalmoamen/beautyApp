<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form @keydown.enter.prevent @submit.prevent="create">
                    <div class="card-header">
                        <div
                            class="d-flex align-items-center justify-content-between"
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
                                {{ __("Insert Stock") }}
                            </h6>
                            <button class="btn btn-primary" type="submit">
                                {{ __("Save") }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    {{ __("Type Name") }}</span
                                >
                            </div>
                            <input
                                readonly
                                aria-describedby="basic-addon1"
                                class="form-control"
                                v-model="type.type_name_ar"
                                type="text"
                                required
                            />
                            <a
                                class="btn btn-info btn text-light"
                                @click="showMainType = !showMainType"
                                ><i
                                    class="fas fa-search font-weight-bold text-light"
                                ></i
                            ></a>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    {{ __("Stock") }}</span
                                >
                            </div>
                            <input
                                readonly
                                aria-describedby="basic-addon1"
                                class="form-control"
                                v-model="stock.title"
                                type="text"
                                required
                            />
                            <a
                                class="btn btn-info btn text-light"
                                @click="showStock = !showStock"
                                ><i
                                    class="fas fa-search font-weight-bold text-light"
                                ></i
                            ></a>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    {{ __("Operation") }}</span
                                >
                            </div>
                            <select
                                v-model="form.unit_id"
                                class="form-select"
                                required
                            >
                                <option
                                    v-for="(op, index) in operations"
                                    :value="op.unit_id"
                                    :key="index"
                                >
                                    {{ op.unit.unit_ar_name }}
                                </option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">{{
                                    __("Decrease From Stock")
                                }}</span>
                            </div>
                            <input
                                aria-describedby="basic-addon2"
                                class="form-control"
                                v-model="form.mount"
                                required
                                type="text"
                            />
                        </div>
                    </div>
                </form>
                <div
                    aria-hidden="true"
                    aria-labelledby="exampleModalLabel"
                    :class="
                        showMainType ? 'modal fade d-block show' : 'modal fade'
                    "
                    role="dialog"
                    tabindex="-1"
                >
                    <div
                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                        role="document"
                    >
                        <div class="modal-content m-auto">
                            <div class="modal-body min-h-50">
                                <div class="table-responsive w-100">
                                    <input
                                        v-model="typeName"
                                        class="form-control-sm"
                                        :placeholder="__('Type Name')"
                                        type="search"
                                    />

                                    <table class="table align-items-center">
                                        <thead>
                                            <tr>
                                                <th class="col-header">
                                                    {{ __("Type Name") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Choose") }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    type, index
                                                ) in filterForType"
                                                :key="index"
                                            >
                                                <td>
                                                    {{ type.type_name_ar }}
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-success btn-sm"
                                                        @click="
                                                            selectMainProduct(
                                                                type
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-plus font-weight-bold text-light"
                                                        ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    class="btn btn-secondary"
                                    @click="
                                        showMainType = !showMainType;
                                        typeName = '';
                                    "
                                    type="button"
                                >
                                    {{ __("Close") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    aria-hidden="true"
                    aria-labelledby="exampleModalLabel"
                    :class="
                        showStock ? 'modal fade d-block show' : 'modal fade'
                    "
                    role="dialog"
                    tabindex="-1"
                >
                    <div
                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                        role="document"
                    >
                        <div class="modal-content m-auto">
                            <div class="modal-body min-h-50">
                                <div class="table-responsive w-100">
                                    <input
                                        v-model="stockName"
                                        class="form-control-sm"
                                        :placeholder="__('Stock')"
                                        type="search"
                                    />

                                    <table class="table align-items-center">
                                        <thead>
                                            <tr>
                                                <th class="col-header">
                                                    {{ __("Name") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Stock") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Choose") }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    stock, index
                                                ) in filterForStock"
                                                :key="index"
                                            >
                                                <td>{{ stock.title }}</td>
                                                <td>{{ stock.stock }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-success btn-sm"
                                                        @click="
                                                            selectStock(stock)
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-plus font-weight-bold text-light"
                                                        ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    class="btn btn-secondary"
                                    @click="
                                        showStock = !showStock;
                                        stockName = '';
                                    "
                                    type="button"
                                >
                                    {{ __("Close") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.form.branch_id = this.user.branch_id;

        //    await this.allOperations();
        await this.allTypes();
        await this.allStocks();
    },
    data() {
        return {
            showMainType: false,
            showStock: false,
            showOpertaion: false,
            operationName: "",
            typeName: "",
            stockName: "",
            products: [],
            stocks: [],
            operations: [],
            type: {},
            opertaion: {},
            stock: {},
            form: {
                type_id: null,
                stock_id: null,
                unit_id: null,
                mount: 0,
            },
            errors: {},
        };
    },
    computed: {
        filterForType() {
            if (this.products) {
                return this.products.filter((type) => {
                    return type.type_name_ar.match(this.typeName);
                });
            }
        },
        filterForStock() {
            return this.stocks.filter((stock) => {
                return stock.title.match(this.stockName);
            });
        },
        filterForOperation() {
            return this.operations.filter((operation) => {
                return operation.unit_ar_name.match(this.operationNamepeName);
            });
        },
    },
    methods: {
        async allTypes() {
            await axios
                .get("/api/types")
                .then(({ data }) => {
                    this.products = data;
                })
                .catch((error) => console.log(error));
        },
        selectMainProduct(type) {
            this.form.type_id = type.type_id;
            this.type = type;
            this.operations = type.units;
            console.log(this.operations);
            this.showMainType = !this.showMainType;
            this.typeName = "";
        },
        async allOperations() {
            await axios
                .get("/api/units")
                .then(({ data }) => {
                    this.operations = data;
                })
                .catch((error) => console.log(error));
        },

        selectOperation(op) {
            this.form.unit_id = op.unit_id;
            this.opertaion = op;
            this.showOpertaion = !this.showOpertaion;
            this.operationName = "";
        },
        async allStocks() {
            await axios
                .get("/api/stocks")
                .then(({ data }) => {
                    this.stocks = data;
                })
                .catch((error) => console.log(error));
        },

        selectStock(stock) {
            this.form.stock_id = stock.id;
            this.stock = stock;

            this.showStock = !this.showStock;
            this.stockName = "";
        },
        create() {
            axios
                .post("/api/gusto/stocks", this.form)
                .then(() => {
                    this.$router.push({ name: "gustoStocks" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>
