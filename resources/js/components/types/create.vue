<template>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <form
                        @keydown.enter.prevent
                        class="types"
                        dir="rtl"
                        enctype="multipart/form-data"
                        @submit.prevent="createType"
                    >
                        <div class="card-header">
                            <div
                                class=" d-flex align-items-center justify-content-between"
                            >
                                <a
                                    class="btn btn-warning text-light float-right"
                                    @click="$router.go(-1)"
                                >
                                    <i
                                        :class="
                                            $root.$data.codies.default_lang ==
                                            'ar'
                                                ? 'fa fa-arrow-right'
                                                : 'fa fa-arrow-left'
                                        "
                                    ></i>
                                </a>
                                <h6 class="m-0 font-weight-bold text-primary">
                                    {{ __("Insert Type Information") }}
                                </h6>
                                <button class="btn btn-success" type="submit">
                                    {{ __("Save") }}
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <img
                                    :src="type.type_icon"
                                    class="card-img-top w-25 h-25 m-auto"
                                />
                                <div class="file-input img_file">
                                    <input
                                        onClick="this.select();"
                                        type="file"
                                        name="file-input"
                                        id="file-input"
                                        class="file-input__input"
                                        @change="onFileSelected"
                                    />
                                    <label
                                        class="file-input__label"
                                        for="file-input"
                                    >
                                        <i class="fa fa-upload"></i>

                                        <span> {{ __("Icon") }}</span></label
                                    >
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ __("Name ar") }}</span
                                    >
                                </div>
                                <input
                                    onClick="this.select();"
                                    v-model="type.type_name_ar"
                                    aria-describedby="basic-addon1"
                                    class="form-control"
                                    type="text"
                                    required
                                />
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ __("Name en") }}</span
                                    >
                                </div>
                                <input
                                    onClick="this.select();"
                                    v-model="type.type_name_en"
                                    aria-describedby="basic-addon1"
                                    class="form-control"
                                    type="text"
                                />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            {{ __("Cost") }}</span
                                        >
                                    </div>
                                    <input
                                        onClick="this.select();"
                                        v-model="type.type_purchases_price"
                                        aria-describedby="basic-addon1"
                                        class="form-control"
                                        type="number"
                                        min="0"
                                        step="0.1"
                                    />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            {{ __("Sill Price") }}</span
                                        >
                                    </div>
                                    <input
                                        onClick="this.select();"
                                        v-model="type.type_sill_price"
                                        aria-describedby="basic-addon1"
                                        class="form-control"
                                        type="number"
                                        required
                                        min="0"
                                        step="0.1"
                                    />
                                    <div class="input-group-prepend d-none">
                                        <span class="input-group-text">
                                            أقل سعر البيع</span
                                        >
                                    </div>
                                    <input
                                        onClick="this.select();"
                                        v-model="type.minimum_sill_price"
                                        aria-describedby="basic-addon1"
                                        aria-label="أقل سعر البيع "
                                        class="form-control d-none"
                                        placeholder="أقل سعر البيع"
                                        type="number"
                                        min="0"
                                        step="0.1"
                                    />
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ __("Category") }}</span
                                    >
                                </div>
                                <select
                                    v-model="type.main_type"
                                    class="form-control-sm w-25"
                                >
                                    <option
                                        v-for="(cat, index) in categories"
                                        :value="cat.main_type_id"
                                        :key="index"
                                    >
                                        {{ cat.main_type_title_ar }}
                                    </option>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ __("Barcode") }}</span
                                    >
                                </div>
                                <input
                                    onClick="this.select();"
                                    v-model="type.type_barcode"
                                    aria-describedby="basic-addon1"
                                    class="form-control"
                                    type="text"
                                />
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ __("Simple Code") }}</span
                                    >
                                </div>
                                <input
                                    onClick="this.select();"
                                    v-model="type.type_code"
                                    aria-describedby="basic-addon1"
                                    class="form-control"
                                    type="text"
                                />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ __("Discount") }}</span
                                    >
                                </div>
                                <input
                                    onClick="this.select();"
                                    v-model="type.type_discount_value"
                                    aria-describedby="basic-addon1"
                                    class="form-control"
                                    type="number"
                                    min="0"
                                    step="0.1"
                                />

                                <div
                                    :class="
                                        $root.$data.codies.fixed_vat
                                            ? 'd-none'
                                            : 'input-group-prepend'
                                    "
                                >
                                    <span class="input-group-text">
                                        {{ __("Vat") }}</span
                                    >
                                </div>
                                <input
                                    onClick="this.select();"
                                    v-model="type.type_vat_percent"
                                    aria-describedby="basic-addon1"
                                    :class="
                                        $root.$data.codies.fixed_vat
                                            ? 'd-none'
                                            : 'form-control'
                                    "
                                    type="number"
                                    min="0"
                                    step="0.1"
                                />
                            </div>

                            <div class="card">
                                <div
                                    class="card-header d-flex flex-row align-items-center justify-content-between"
                                >
                                    <table
                                        v-show="selected_units.length > 0"
                                        class="table-bordered text-center w-50"
                                    >
                                        <thead>
                                            <tr>
                                                <th>
                                                    {{ __("Unit") }}
                                                </th>
                                                <th>
                                                    {{ __("Price") }}
                                                </th>
                                                <th>X</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    selected, index
                                                ) in selected_units"
                                                :key="index"
                                                class="text-center"
                                            >
                                                <td>
                                                    <select
                                                        v-model="
                                                            selected.unit_id
                                                        "
                                                        class="form-control-sm"
                                                        @change="
                                                            onChangeCountCalcPrice(
                                                                selected
                                                            )
                                                        "
                                                    >
                                                        <option
                                                            v-for="(
                                                                unit, i
                                                            ) in units"
                                                            :value="unit"
                                                            :key="i"
                                                        >
                                                            {{
                                                                unit.unit_ar_name
                                                            }}
                                                        </option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input
                                                        onClick="this.select();"
                                                        v-model="selected.price"
                                                        class="form-control-sm"
                                                        type="number"
                                                        min="0"
                                                        step="0.1"
                                                    />
                                                </td>

                                                <td style="width: 5%">
                                                    <button
                                                        class="btn-sm btn-danger"
                                                        @click="
                                                            removeUnit(
                                                                selected,
                                                                index
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-times"
                                                        ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="input-group-prepend">
                                        <a
                                            class="btn btn-sm btn-success"
                                            @click="addUnit()"
                                        >
                                            {{ __("Add Unit") }}
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                    <div
                                        v-show="selected_units.length > 0"
                                        class="input-group-prepend"
                                    >
                                        <span
                                            class="input-group-text btn btn-sm"
                                            for="selectUnit"
                                        >
                                            {{ __("Default Operation") }}</span
                                        >
                                        <select
                                            id="selectUnit"
                                            v-model="type.sell_unit"
                                            style="width: 150px"
                                        >
                                            <option
                                                v-for="(
                                                    selected, index
                                                ) in selected_units"
                                                :key="index"
                                                :value="
                                                    selected.unit_id.unit_id
                                                "
                                            >
                                                {{
                                                    selected.unit_id
                                                        .unit_ar_name
                                                }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-body"></div>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend d-none">
                                    <span class="input-group-text"
                                        >مكان الصنف</span
                                    >
                                </div>
                                <input
                                    onClick="this.select();"
                                    v-model="type.type_location"
                                    aria-describedby="basic-addon1"
                                    aria-label="مكان الصنف"
                                    class="form-control d-none"
                                    placeholder="مكان الصنف"
                                    type="text"
                                />
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ __("Notes") }}</span
                                    >
                                </div>
                                <input
                                    onClick="this.select();"
                                    v-model="type.type_note"
                                    aria-describedby="basic-addon1"
                                    aria-label="ملاحظــــات الصنف"
                                    class="form-control"
                                    placeholder="ملاحظــــات الصنف"
                                    type="text"
                                />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.type.branch_id = this.user.branch_id;

        await this.allMainType();
        await this.allUnits();
        await axios
            .get("/api/last/id")
            .then(({ data }) => {
                this.id = data;
            })
            .catch((error) => console.log(error));
    },
    data() {
        return {
            id: null,
            type: {
                type_name_ar: "",
                type_name_en: "",
                type_icon: "",
                type_location: "",
                type_purchases_price: 0.0,
                type_count: 0,
                type_has_vat: true,
                type_vat_value: 0.0,
                type_vat_percent: 0.0,
                type_note: "",
                type_sill_price: 0.0,
                type_discount_value: 0.0,
                type_discount_percent: 0.0,
                total_type_cost: 0.0,
                type_barcode: null,
                type_exp_date: null,
                sell_unit: null,
                lg_unit: null,
                md_unit: null,
                no_md_unit: null,
                sm_unit: null,
                no_sm_unit: null,
                diff_md_unit_price: null,
                diff_sm_unit_price: null,
                is_deleted: null,
                minimum_sill_price: null,
                type_code: null,
                prevent_use: null,
                main_type: null,
                type_unit: [],
            },
            categories: [],
            errors: {},
            type_units: {
                unit_id: "",
                no_of_unit: 1,
                deff_price: 0.0,
                price: 0.0,
                barcode: "",
            },
            selected_units: [],
            units: [],
        };
    },

    methods: {
        generateBarcode() {
            this.type.type_barcode = "";

            if (this.id > 10000) {
                var val1 = Math.floor(this.id + Math.random() * 99);
                this.type.type_barcode = val1;
            } else {
                var val1 = Math.floor(100 + Math.random() * 99);
                this.type.type_barcode = this.id + 1 + "" + val1;
            }
        },

        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                Notification.image_validation();
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.type.type_icon = event.target.result;
                    console.log(event.target.result);
                };
                reader.readAsDataURL(file);
            }
        },

        allMainType() {
            axios
                .get("/api/mainTypes")
                .then(({ data }) => {
                    this.categories = data;
                })
                .catch((error) => console.log(error));
        },
        allUnits() {
            axios
                .get("/api/units")
                .then(({ data }) => {
                    this.units = data;
                })
                .catch((error) => console.log(error));
        },

        calcVatVal() {
            this.type.type_vat_value = 0;
            if (
                this.type.type_sill_price > 0 &&
                this.type.type_vat_percent > 0
            ) {
                if (this.type.type_has_vat) {
                    let price =
                        this.type.type_sill_price /
                        (1 + this.type.type_vat_percent / 100.0);
                    this.type.type_vat_value =
                        ((price - this.type.type_discount_value) *
                            this.type.type_vat_percent) /
                        100.0;
                } else {
                    this.type.type_vat_value =
                        ((this.type.type_sill_price -
                            this.type.type_discount_value) *
                            this.type.type_vat_percent) /
                        100.0;
                }
            }
        },

        calcDiscountVal() {
            this.type.type_discount_value = 0;
            if (
                this.type.type_sill_price > 0 &&
                this.type.type_discount_percent > 0
            ) {
                this.type.type_discount_value =
                    (this.type.type_sill_price *
                        this.type.type_discount_percent) /
                    100.0;
            }
        },

        addUnit() {
            let TypeUnits = JSON.parse(JSON.stringify(this.type_units));
            this.selected_units.push(TypeUnits);
        },
        removeUnit(selected, index) {
            selected.no_of_unit = 1;
            selected.price = 0;
            this.$delete(this.selected_units, index);
        },
        onChangeCountCalcPrice(selected) {
            selected.price = 0;
            selected.price =
                this.type.type_sill_price / selected.no_of_unit +
                Number(selected.deff_price);
        },
        createType() {
            if (this.selected_units <= 0) {
                Notification.customMsg(
                    "error",
                    "topRight",
                    "يجب اختيار وحدة واحدة على الأقل"
                );
                return;
            }
            if (this.type.sell_unit == null) {
                Notification.customMsg(
                    "error",
                    "topRight",
                    "يجب اختيار وحدة بيع "
                );
                return;
            }
            this.createTypeWithValidData();
        },
        createTypeWithValidData() {
            if (this.selected_units.length > 0) {
                this.type.type_unit = this.selected_units;
            }
            axios
                .post("/api/types", this.type)
                .then((type) => {
                    this.$router.push({ name: "types" });

                    Notification.success();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .then((e) => {
                    if (this.errors.type_name_ar)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.type_name_ar[0]
                        );
                    if (this.errors.type_sill_price)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.type_sill_price[0]
                        );
                    if (this.errors.type_barcode)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.type_barcode[0]
                        );
                    if (this.errors.type_unit)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.type_unit[0]
                        );
                });
        },
    },
};
</script>
<style>
label {
    float: right;
}

.pointer {
    cursor: pointer;
}
</style>
