<template>
    <div class="row">
        <div v-if="!isLoading" class="col-12">
            <form @keydown.enter.prevent enctype="multipart/form-data" @submit.prevent="saveChanges">
                <div class="card">
                    <div class="card-header">
                        <h6 class="font-weight-bold text-primary float-right d-inline">
                            {{ __("Main Settings") }}
                        </h6>
                        <button type="submit" class="btn btn-primary float-left">
                            {{ __("Save") }}
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        {{ __("System Info") }}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label> {{ __("Name") }} </label>
                                        <input type="text" class="form-control-sm" v-model="mixins.mixins_name" />
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Location") }}</label>
                                        <input type="text" class="form-control-sm" v-model="mixins.mixins_adress" />
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Name en") }}</label>
                                        <input type="text" class="form-control-sm" v-model="mixins.mixins_name_en" />
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Location en") }}</label>
                                        <input type="text" class="form-control-sm" v-model="mixins.mixins_adress_en" />
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="custom-file mt-5">
                                                    <input type="file" class="custom-file-input" @change="onFileSelected" />
                                                    <label class="custom-file-label">
                                                        {{ __("Logo") }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <img v-if="mixins_new_logo" :src="mixins.mixins_new_logo
                                                    " style="
                                                        height: 170px;
                                                        width: 170px;
                                                    " />
                                                <img v-else :src="mixins.mixins_logo" style="
                                                        height: 170px;
                                                        width: 170px;
                                                    " />
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="custom-file mt-5">
                                                    <input type="file" class="custom-file-input" @change="onFileSelectedBg" />
                                                    <label class="custom-file-label">
                                                        {{ __("mixins_background") }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <img v-if="new_background" :src="mixins.new_background
                                                    " style="
                                                        height: 170px;
                                                        width: 170px;
                                                    " />
                                                <img v-else :src="mixins.mixins_background" style="
                                                        height: 170px;
                                                        width: 170px;
                                                    " />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Mobile") }} </label>
                                        <input type="text" class="form-control-sm" v-model="mixins.mixins_mobile" />
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Logo width") }} </label>
                                        <input type="number" class="form-control-sm" v-model="mixins.logo_width" />
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Logo height") }} </label>
                                        <input type="number" class="form-control-sm" v-model="mixins.logo_height" />
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            {{ __("Sales Types") }}
                                        </label>
                                        <select v-model="mixins.sale_type" class="form-select">
                                            <option :value="NullSale">
                                                {{ __("Choose Sales Type") }}
                                            </option>
                                            <option v-for="(
                                                    sale, index
                                                ) in salesTypes" :key="index" :value="sale.id">
                                                {{ sale.sill_type_name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __("Currency") }}</label>
                                        <select v-model="mixins.currency" class="form-select">
                                            <option v-for="(
                                                    currency, index
                                                ) in currencies" :key="index" :value="currency">
                                                {{ currency.currency_ar }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            {{ __("Closure Time") }}
                                        </label>
                                        <select v-model="mixins.closure_hour" class="form-select">
                                            <option v-for="(h, index) in 23" :key="index" :value="h">
                                                {{
                                                    h < 12 ? h + " AM" : (h - 12 == 0 ? "12" : h - 12) + " PM" }} </option>
                                            <option value="00">12 AM</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="weight_barcode"
                                                v-model="mixins.weight_barcode" />
                                            <label class="custom-control-label" for="weight_barcode">
                                                {{ __("weight_barcode") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __("Footer notes") }} </label>
                                        <textarea class="form-control" v-model="mixins.mixins_note" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        {{ __("Vat Details") }}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group d-none">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="processBills"
                                                v-model="mixins.process_bills" />
                                            <label class="custom-control-label" for="processBills">
                                                {{ __("ProcessBills") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="fixed_vat"
                                                v-model="mixins.fixed_vat" />
                                            <label class="custom-control-label" for="fixed_vat">
                                                {{ __("Fixed vat") }}</label>
                                        </div>
                                    </div>
                                    <div v-show="mixins.fixed_vat" class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                id="mixins_price_include_vat" v-model="mixins.mixins_price_include_vat
                                                    " />
                                            <label class="custom-control-label" for="mixins_price_include_vat">
                                                {{ __("Prices include vat") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div v-show="mixins.fixed_vat" class="form-group">
                                        <label>{{ __("Vat Percent") }} </label>
                                        <input type="text" class="form-control-sm" v-model="mixins.mixins_vat_val" />
                                    </div>
                                    <div v-show="mixins.fixed_vat" class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="smoken_vat"
                                                v-model="mixins.smoken_vat" />
                                            <label class="custom-control-label" for="smoken_vat">
                                                {{ __("smoken_vat") }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label> {{ __("Vat number") }} </label>
                                        <input type="text" class="form-control-sm" v-model="mixins.contruct_no" />
                                    </div>
                                </div>
                            </div>
                            <!-- Input Group -->

                            <div class="card mb-3">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        {{ __("General Settings") }}
                                    </h6>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="same_type" v-model="mixins.same_type
                                                " />
                                            <label class="custom-control-label" for="same_type">
                                                {{ __("same_type") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="active_distributing"
                                                v-model="mixins.active_distributing
                                                    " />
                                            <label class="custom-control-label" for="active_distributing">
                                                {{ __("active_distributing") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label> {{ __("digit") }}</label>
                                            <input type="number" class="form-control-sm" v-model="mixins.digit" />
                                        </div>
                                    </div>
                                    <div class="form-group d-none" v-if="this.jsPrint === '0'">
                                        <label>
                                            {{ __("default_printer") }}</label>
                                        <select name="default_printer" id="default_printer"
                                            v-model="mixins.default_printer">
                                            <option disabled n-bind:key="undefined">
                                                Select printer
                                            </option>
                                            <option v-for="printer in printers" v-bind:key="printer">
                                                {{ printer }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group d-none" v-if="mixins.active_distributing">
                                        <label>
                                            {{
                                                __("Distributing")
                                            }}(jsPrint)</label>
                                        <select class="form-select" v-model="jsPrint">
                                            <!-- <option value="0">Default</option> -->
                                            <option value="1">JsSetup</option>
                                            <!-- <option value="2">
                                                JSPrintManager
                                            </option> -->
                                        </select>
                                    </div>
                                    <div class="form-group d-none">
                                        <label>{{ __("Counrty") }}</label>
                                        <select class="form-select" v-model="mixins.country">
                                            <option value="1">مصر</option>
                                            <option value="2">السعودية</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        {{ __("Email") }}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group d-none">
                                        <div class="form-group">
                                            <label> {{ __("Email") }}</label>
                                            <input type="email" class="form-control-sm" v-model="mixins.email_from" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Email") }} </label>
                                        <input type="email" class="form-control-sm" v-model="mixins.email_to" />
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Report time") }}</label>
                                        <input type="time" class="form-control-sm" v-model="mixins.send_time" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        {{ __("New Bill") }}
                                    </h6>
                                </div>

                                <div class="card-body">
                                    <div class="form-group d-none">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="bill_with_main_type"
                                                v-model="mixins.bill_with_main_type
                                                    " />
                                            <label class="custom-control-label" for="bill_with_main_type">أصناف
                                                رئيسية</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{
                                            __("bill_lang")
                                        }}</label>
                                        <select v-model="mixins.bill_lang" class="form-select">
                                            <option value="ar">ar</option>
                                            <option value="ar-en">ar-en</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{
                                            __("Number Of Copy")
                                        }}</label>
                                        <select v-model="mixins.printer_count" class="form-select">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="form-group d-none">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="use_type_uints"
                                                v-model="mixins.use_type_uints" />
                                            <label class="custom-control-label" for="use_type_uints">تفعيل الوحدات
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label> {{ __("Printer type") }}</label>
                                        <select class="form-select" v-model="mixins.printer_type">
                                            <option value="1">حرارية</option>
                                            <option value="2">A4</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="show_side_menu"
                                                v-model="mixins.show_side_menu" />
                                            <label class="custom-control-label" for="show_side_menu">
                                                {{ __("show side menu") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="pretty"
                                                v-model="mixins.pretty" />
                                            <label class="custom-control-label" for="pretty">
                                                {{ __("Show types as Column") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="as_card"
                                                v-model="mixins.as_card" />
                                            <label class="custom-control-label" for="as_card">
                                                {{
                                                    __(
                                                        "Show Bill types As Card"
                                                    )
                                                }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            {{
                                                __("Choosen Type Count In Row")
                                            }}
                                        </label>
                                        <select v-model="mixins.count_in_row_bill" class="form-select">
                                            <option value="col-12">1</option>
                                            <option value="col-6">2</option>
                                            <option value="col-4">3</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            {{
                                                __(
                                                    "Choosen Main Type Count In Row"
                                                )
                                            }}
                                        </label>
                                        <select v-model="mixins.count_in_row_main" class="form-select">
                                            <option value="col-12">1</option>
                                            <option value="col-6">2</option>
                                            <option value="col-4">3</option>
                                            <option value="col-3">4</option>
                                            <option value="col-2">6</option>
                                            <option value="col-1">12</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        {{ __("Offers") }}
                                    </h6>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="active_type_offer"
                                                v-model="mixins.active_type_offer
                                                    " />
                                            <label class="custom-control-label" for="active_type_offer">
                                                {{ __("Active Offer On type") }}
                                            </label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="active_offer"
                                                v-model="mixins.active_offer" />
                                            <label class="custom-control-label" for="active_offer">
                                                {{ __("Active Offers") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __("Offer Start Date") }}
                                        </label>
                                        <input type="date" class="form-control-sm" v-model="mixins.offer_start_date" />
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __("Offer End Date") }}
                                        </label>
                                        <input type="date" class="form-control-sm" v-model="mixins.offer_end_date" />
                                    </div>
                                    <div class="form-group d-none">
                                        <label>قيمة العرض</label>
                                        <input type="number" min="0" :readonly="mixins.offer_percenet > 0
                                            " class="form-control-sm" v-model="mixins.offer_value" />
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            {{
                                                __("Offer Discount Percent")
                                            }}</label>
                                        <input type="number" min="0" :readonly="mixins.offer_value > 0"
                                            class="form-control-sm" v-model="mixins.offer_percenet" />
                                    </div>
                                </div>
                            </div>





                            <div class="card mb-3">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        {{ __("points") }}
                                    </h6>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="active_point" v-model="mixins.active_point
                                                " />
                                            <label class="custom-control-label" for="active_point">
                                                {{ __("active_point") }}
                                            </label>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label>{{ __("point_price") }}
                                        </label>
                                        <input type="number" min="0" class="form-control-sm" v-model="mixins.point_price" />
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __("valid_days") }}
                                        </label>
                                        <input type="number" min="0" class="form-control-sm" v-model="mixins.valid_days" />
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            {{
                                                __("point_every")
                                            }} {{ mixins.currency.currency_ar }}</label>
                                        <input type="number" min="0" class="form-control-sm" v-model="mixins.point_every" />
                                    </div>
                                </div>
                            </div>





                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        await this.allSalesType();
        this.user = await Auth.getAuth();

        await axios
            .get("/api/currency")
            .then(({ data }) => (this.currencies = data))
            .catch((err) => console.log(err));
        await axios
            .get("/api/mixins/" + this.user.branch_id)
            .then(({ data }) => {
                this.mixins = data;
                this.isLoading = false;
            })
            .catch((err) => console.log(err));
    },
    data() {
        return {
            user: {},
            jsPrint: "",
            isShow: "",
            isLoading: true,
            mixins: {},
            mixins_new_logo: "",
            printers: [],
            currencies: [],
            salesTypes: [],
            NullSale: null,
            new_background:null,
        };
    },
    methods: {
        allSalesType() {
            axios
                .get("/api/saleType")
                .then(({ data }) => {
                    console.log(data);
                    if (data.length >= 0) {
                        this.salesTypes = data;
                    }
                })
                .catch((error) => console.log(error));
        },
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                Notification.image_validation();
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.mixins.mixins_new_logo = event.target.result;
                    this.mixins_new_logo = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
         onFileSelectedBg(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                Notification.image_validation();
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.mixins.new_background = event.target.result;
                    this.new_background = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        saveChanges() {
            localStorage.setItem("jsPrint", this.jsPrint);

            axios
                .patch("/api/mixins/" + this.user.branch_id, this.mixins)
                .then(async () => {
                    //   await this.$router.push({ name: "/" });

                    await location.reload(true);
                    Notification.success();
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
        showDropDown() {
            this.isShow = !this.isShow;
        },
    },
};
</script>
<style scoped>
input {
    min-width: 100%;
}
</style>
