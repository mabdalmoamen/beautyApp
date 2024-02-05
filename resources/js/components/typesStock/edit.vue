<template>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mb-4">
                <form @keydown.enter.prevent @submit.prevent="update">
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
                                تعديل بيانات المخزون
                            </h6>
                            <button class="btn btn-primary" type="submit">
                                حفظ
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
                                v-model="form.type_id.type_name_ar"
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
                                v-model="form.stock_id.title"
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
                                    :value="op.unit"
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
                                type="text"
                                required
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
                        <div
                            class="modal-content m-auto"
                            style="min-width: 800px"
                        >
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
                                                ) in products"
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
                        <div
                            class="modal-content m-auto"
                            style="min-width: 800px"
                        >
                            <div class="modal-body min-h-50">
                                <div class="table-responsive w-100">
                                    <input
                                        v-model="typeName"
                                        class="form-control-sm"
                                        :placeholder="__('Stock')"
                                        type="search"
                                    />
                                    <button
                                        class="btn btn-sm btn-info"
                                        @click="allStocks()"
                                    >
                                        <i
                                            class="fa fa-search font-weight-bold text-light"
                                        ></i>
                                    </button>
                                    <table class="table align-items-center">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="col-header"
                                                    style="width: 10%"
                                                >
                                                    {{ __("Name") }}
                                                </th>
                                                <th
                                                    class="col-header"
                                                    style="width: 20%"
                                                >
                                                    {{ __("Stock") }}
                                                </th>
                                                <th
                                                    class="col-header"
                                                    style="width: 5%"
                                                >
                                                    {{ __("Choose") }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(stock, index) in stocks"
                                                :key="index"
                                            >
                                                <td>{{ stock.id }}</td>
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

<script type="text/javascript">
export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        let id = this.$route.params.id;
        await axios
            .get("/api/gusto/stocks/" + id)
            .then(({ data }) => {
                this.form = data;
                this.operations = this.form.type_id.units;
            })
            .catch((error) => console.log(error));
        // this.allOperations();
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
                type_id: {},
                stock_id: {},
                unit_id: {},
                mount: 0,
            },
            errors: {},
        };
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
            this.form.type_id = type;
            this.type = type;
            this.operations = type.units;
            this.showMainType = !this.showMainType;
            this.typeName = "";
        },

        async allStocks() {
            await axios
                .get("/api/stocks")
                .then(({ data }) => {
                    this.stocks = data.data;
                })
                .catch((error) => console.log(error));
        },

        selectStock(stock) {
            this.form.stock_id = stock;
            this.showStock = !this.showStock;
            this.stockName = "";
        },
        update() {
            this.form.type_id = this.form.type_id.type_id;
            this.form.stock_id = this.form.stock_id.id;
            this.form.unit_id = this.form.unit_id.unit_id;

            let id = this.$route.params.id;
            axios
                .patch("/api/gusto/stocks/" + id, this.form)
                .then(() => {
                    this.$router.push({ name: "gustoStocks" });
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>

<style type="text/css"></style>
