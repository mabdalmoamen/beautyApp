<template>
    <div class="row">
        <!-- Datatables -->
        <div v-if="!loading" class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="codies-table d-flex justify-content-between">
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
                        <h3 class="card-title mt-2">{{ __("Types") }}</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input
                                    type="text"
                                    class="form-control-sm text-success"
                                    v-model="searchTerm"
                                    style="color: green !important"
                                    :placeholder="__('Search')"
                                    @keydown="$event.stopImmediatePropagation()"
                                />
                            </div>
                        </div>

                        <div class="card-tools">
                            <div
                                class="input-group input-group-sm"
                                v-if="user.delete_type"
                            >
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    v-model="selectAll"
                                    id="flexCheckDefault"
                                />
                                <label
                                    class="form-check-label mx-3 pointer"
                                    for="flexCheckDefault"
                                >
                                    {{ __("Select All") }}
                                </label>
                                <span class="mx-2" v-if="selectAll">
                                    <!-- You are currently selecting all -->
                                    {{ __("Selected ") }}
                                    <strong>{{ checked.length }}</strong>
                                    {{ __("Type") }}
                                </span>
                                <a
                                    v-if="checked.length > 0"
                                    class="btn btn-sm btn-danger card-link"
                                    href="#"
                                    onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                    type="button"
                                    @click.prevent="deleteRecords"
                                >
                                    {{ __("Delete Selected") }}
                                </a>
                            </div>
                        </div>
                        <div class="card-tools">
                            <i
                                class="fas fa-file-excel text-success"
                                style="cursor: pointer"
                                @click="downloads('xlsx', 'types')"
                            ></i>
                        </div>

                        <div class="card-link">
                            <router-link
                                v-show="user.create_type"
                                class="font-weight-bold text-primary"
                                to="/create/type"
                            >
                                {{ __("Create") }}
                            </router-link>
                        </div>
                    </div>
                </div>
                <div id="body" class="table-responsive">
                    <table
                        v-if="types.length > 0"
                        id="types"
                        class="table table-bordered table-striped"
                    >
                        <thead>
                            <tr>
                                <th>{{ __('Edit') }}</th>

                                <th class="d-none">كود</th>

                                <th>{{ __('Type Name') }}</th>
                                <th>{{ __('Name en') }}</th>
                                <th>{{ __('Icon') }}</th>
                                <th>{{ __('Cost') }}</th>
                                <th> {{ __('Sill Price') }}</th>

                                <th>{{ __('Discount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(type, index) in filterSearch"
                                :key="index"
                                class="ErrorRow"
                            >
                                <td v-if="!isNewbill">
                                    <input
                                        v-show="user.delete_type"
                                        type="checkbox"
                                        :value="type.type_id"
                                        v-model="checked"
                                    />

                                    <router-link
                                        :to="{
                                            name: 'edit-type',
                                            params: {
                                                id: type.type_id,
                                            },
                                        }"
                                        class="btn btn-sm btn-primary"
                                        ><i class="fa fa-edit"></i>
                                    </router-link>
                                    <a
                                        class="btn btn-sm btn-danger d-none"
                                        @click="deleteType(type.type_id)"
                                        ><i class="fa fa-trash"></i
                                    ></a>
                                </td>
                                <td v-else>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary"
                                        @click="addToCart(type)"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                <td class="d-none">
                                    {{ type.type_id }}
                                </td>
                                <td class="d-none">
                                    {{ type.type_barcode }}
                                </td>
                                <td style="overflow: auto">
                                    {{ type.type_name_ar }}
                                </td>
                                <td>{{ type.type_name_en }}</td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button
                                        v-show="
                                            type.type_icon !== '' ||
                                            type.type_icon != null
                                        "
                                        :data-target="
                                            '#exampleModalCenter-' +
                                            type.type_id
                                        "
                                        class="btn btn-sm btn-info text-light"
                                        data-toggle="modal"
                                        type="button"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <div
                                        :id="
                                            'exampleModalCenter-' + type.type_id
                                        "
                                        aria-hidden="true"
                                        aria-labelledby="exampleModalCenterTitle"
                                        class="modal fade"
                                        role="dialog"
                                        tabindex="-1"
                                    >
                                        <div
                                            class="modal-dialog modal-dialog-centered"
                                            role="document"
                                        >
                                            <div
                                                class="modal-content"
                                                style="width: 500px"
                                            >
                                                <div
                                                    class="modal-body"
                                                    style="width: 500px"
                                                >
                                                    <img
                                                        :src="type.type_icon"
                                                        style="
                                                            width: 100%;
                                                            height: 100%;
                                                        "
                                                    />
                                                </div>
                                                <div class="modal-footer py-1">
                                                    <button
                                                        class="btn-sm btn btn-secondary"
                                                        data-dismiss="modal"
                                                        type="button"
                                                    >
                                                        إغلاق
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ type.type_purchases_price }}
                                </td>
                                <td>{{ type.type_sill_price }}</td>

                                <td>
                                    {{ type.type_discount_value }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                    <p v-else class="text-center">
                        {{ __("No Data Yet") }}
                    </p>
                </div>
            </div>
        </div>
        <!-- DataTable with Hover -->

        <Spinner v-else :title="title"></Spinner>
        <!-- DataTable with Hover -->
    </div>
</template>

<script>
import Spinner from "../spinner/loading.vue";
import JsBarcode from "jsbarcode";

export default {
    components: { Spinner },
    props: {
        isNewbill: Boolean,
        addToCart: Function,
    },

    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();

        await this.allTypes();
        await axios
            .get("/api/barcodes/" + 1)
            .then(({ data }) => {
                this.barcode = data;
            })
            .catch((error) => console.log(error));
    },
    watch: {
        selectAll: function (value) {
            this.checked = [];
            if (value) {
                this.types.forEach((row) => {
                    this.checked.push(row.type_id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },
    },
    data() {
        return {
            user: {},
            title: "Types",
            filter: "",
            sections: {},
            checked: [],
            selectPage: false,
            selectAll: false,

            types: [],
            searchTerm: "",
            loading: true,
            total: 1,
            page: 1,
            current_page: "",
            last_page: "",
            typeName: "",
            barcode: {},

            types: [],
            per_page: 25,
        };
    },
    computed: {
        filterSearch() {
            return this.types.filter((type) => {
                return type.type_name_ar.match(this.searchTerm);
            });
        },
    },
    methods: {
        downloads(type, name) {
            var wb = XLSX.utils.table_to_book(document.getElementById(name), {
                sheet: "sheet js",
            });
            return XLSX.writeFile(wb, name + "." + type);
        },
        selectAllRecords() {
            axios.get("/api/cashier/types").then((response) => {
                this.checked = response.data;
                this.selectAll = !this.selectAll;
            });
        },

        deleteRecords() {
            axios
                .delete("/api/types/massDestroy/" + this.checked)
                .then((response) => {
                    this.checked.filter((id) => {
                        this.types = this.types.filter((type) => {
                            return type.type_id !== id;
                        });
                    });

                    Notification.successMsg("تم الحذف بنجاح");
                    this.checked = [];
                })
                .catch(() => {
                    Notification.error();
                });
        },
        isChecked(type_id) {
            return this.checked.includes(type_id);
        },
        async printBarcode(type) {
            let barcode = type.type_barcode;
            if (
                type.type_barcode == null ||
                type.type_barcode === "" ||
                type.type_barcode.length === 0
            ) {
                barcode = type.type_id;
            }
            JsBarcode(".barcode", barcode, {
                textAlign: this.barcode.textAlign,
                textPosition: this.barcode.textPosition,
                font: this.barcode.font,
                fontOptions: this.barcode.fontOptions,
                textMargin: this.barcode.textMargin,
                format: this.barcode.format,
                displayValue: this.barcode.displayValue,
                height: this.barcode.height,
                width: this.barcode.width,
                fontSize: this.barcode.fontSize,
                background: this.barcode.background,
                lineColor: this.barcode.lineColor,
                margin: this.barcode.margin,
                marginLeft: this.barcode.marginLeft,
                marginTop: this.barcode.marginTop,
                marginBottom: this.barcode.marginBottom,
                marginRight: this.barcode.marginRight,
                flat: this.barcode.flat,
            });
            this.$htmlToPaper("printMe");
        },
        findTypeByLike() {
            axios
                .get("/api/action/like/" + this.typeName)
                .then(({ data }) => {
                    this.types = data;
                })
                .catch((error) => console.log(error));
        },
        allTypes() {
            axios
                .get("/api/types?page=" + this.page)
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.loading = false;
                        this.types = data;
                    }
                })
                .catch((error) => console.log(error));
        },

        nextPage(i) {
            this.page = i;
            this.allTypes();
        },
        deleteType(id) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("/api/types/" + id)
                    .then((data) => {
                        this.types = this.types.filter((type) => {
                            return type.type_id !== id;
                        });
                        Notification.successMsg("تم الحذف بنجاح");
                    })
                    .catch((error) => {
                        Notification.errorMsg(
                            "لايمكن حذف صنف مرتبط بفواتير او عمليات"
                        );
                    });
            }
        },
    },
};
</script>
<style>
a,
a:hover {
    text-decoration: none;
    font-weight: bolder;
}

table.table-fit thead th,
table.table-fit tfoot th {
    width: auto !important;
}

table.table-fit tbody td,
table.table-fit tfoot td {
    width: auto !important;
}
</style>
