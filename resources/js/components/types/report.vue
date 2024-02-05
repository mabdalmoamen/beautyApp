<template>
    <div class="card">
        <div class="card-header">

            <div class="alert alert-danger" style="display: none">
                يجب تحديد فتره (من-الى)
            </div>
            <form name="form" @submit.prevent="report()" class="needs-validation mt-2 hideMeInPrint">
                <div class="form-row justify-content-center">
                    <div class="col-md-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="from">{{
                                __("From")
                            }}</label>
                            <div class="col-sm-8">
                                <date-picker class="form-control" v-model="from" id="from" :wrap="true"
                                    :config="configs.wrap" :placeholder="__('From')">
                                </date-picker>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="to">{{
                                __("To")
                            }}</label>
                            <div class="col-sm-8">
                                <date-picker class="form-control" v-model="to" id="to" :wrap="true" :config="configs.wrap"
                                    :placeholder="__('To')">
                                </date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <select class="form-control" v-model="cat_id">
                                <option value="">كل الاصناف الرئيسية</option>
                                <option v-for="cat in categories" :key="cat.main_type_id" :value="cat.main_type_id">
                                    {{ cat.main_type_title_ar }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <select v-model="period" class="form-control" name="period">
                                <option value="daily">
                                    {{ __("Daily") }}
                                </option>
                                <option value="monthly">
                                    {{ __("Monthly") }}
                                </option>
                                <option value="period">
                                    {{ __("Period") }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group row">
                            <label class="col-sm-6 col-form-label" for="type_id">{{ __("Code") }}</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="type_id" id="type_id" v-model="type_id" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-success" type="submit">
                            {{ __("View") }}
                        </button>
                        <button @click="print" class="btn btn-success" type="submit">
                            {{ __("Print") }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div id="printMe" class="card-body">
            <div class="pos-section w-100">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 col-md-3 col-sm-12  text-right">
                            <span class="w-100 d-block">{{
                                mixins.mixins_name
                            }}</span>
                            <span class="w-100 d-block">
                                {{ mixins.mixins_adress }}</span>
                            <span class="w-100 d-block">{{
                                mixins.mixins_mobile
                            }}</span>
                            <span class="w-100 d-block">{{
                                mixins.contruct_no
                            }}</span>
                        </div>
                        <div class="col-12 col-md-6 col-sm-12">
                            <div class="text-center">
                                <p v-if="period == 'daily'">
                                    تقرير مبيعات الأصناف يوم :
                                    {{
                                        moment()
                                            .locale("ar")
                                            .format("dddd")
                                    }}
                                    {{
                                        moment()
                                            .locale("ar")
                                            .format("DD-MM-YYYY")
                                    }}
                                </p>
                                <p v-else-if="period == 'monthly'">
                                    تقرير مبيعات الأصناف شهر :
                                    {{
                                        moment()
                                            .locale("ar")
                                            .format("MMMM-YYYY")
                                    }}
                                </p>
                                <p v-else v-show="from && to">
                                    تقرير مبيعات الأصناف من{{
                                        moment(from)
                                            .locale("ar")
                                            .format("DD-MM-YYYY")
                                    }}
                                    إلى
                                    {{
                                        moment(to)
                                            .locale("ar")
                                            .format("DD-MM-YYYY")
                                    }}
                                </p>

                            </div>
                        </div>
                        <div v-if="mixins.show_en_data" class="col-12 col-md-3 col-sm-12 text-left">
                            <span class="w-100 d-block text-left">{{
                                mixins.mixins_name_en
                            }}</span>
                            <span class="w-100 d-block text-left">
                                {{ mixins.mixins_adress_en }}</span>
                            <span class="w-100 d-block text-left">{{
                                mixins.mixins_mobile
                            }}</span>
                            <span class="w-100 d-block text-left">{{
                                mixins.contruct_no
                            }}</span>
                        </div>
                    </div>
                </div>
                <table class="text-center w-100">
                    <thead>
                        <tr>
                            <th>{{ __("Type Name") }}</th>
                            <th>{{ __("Count") }}</th>
                            <th>{{ __("total_sill_price") }}</th>
                        </tr>
                    </thead>
                    <tbody v-if="types.length > 0">
                        <tr v-for="type in types">
                            <td>{{ type.type.type_name_ar }}</td>
                            <td>{{ type.count }}</td>
                            <td>{{ type.price }}</td>
                        </tr>
                    </tbody>
                    <tfoot v-if="types.length > 0">
                        <tr>
                            <th>الاجمالي</th>
                            <td>{{ total_cost }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";

export default {
    async created() {
        this.period = "daily";
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
        await this.allmainTypes();
        await this.report();
    },
    data() {
        return {
            configs: {
                wrap: {
                    allowInputToggle: true,
                },
            },
            user: {},
            mixins: {},
            moment: moment,
            cat_id: "",
            period: "",
            type_id: "",
            from: "",
            to: "",
            types: [],
            total_cost: 0.0,
            categories: [],
        };
    },
    methods: {
        print() {
            this.$htmlToPaper("printMe");
        },
        allmainTypes() {
            axios
                .get("/api/mainTypes")
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.categories = data;
                    }
                })
                .catch((error) => console.log(error));
        },
        add(type) {
            this.total_cost = 0.0;
            let count = type.type_count;
            let rQty = type.total_return_qty;
            count -= rQty;
            let price = count * type.type_price;
            const found = this.types.some(
                (el) => parseInt(el.type.type_id) === parseInt(type.type_id)
            );
            if (!found) {
                this.types.push({ price, count, type: type.type });
            } else {
                this.types.filter((el) => {

                    if (parseInt(el.type.type_id) === parseInt(type.type_id)) {
                        el.count += count;
                        el.price += price;
                    }
                });
            }
            this.types.forEach((el) => {
                let vat = 0;

                if (
                    !this.mixins.mixins_price_include_vat &&
                    this.mixins.fixed_vat
                ) {
                    let vatVal = this.mixins.mixins_vat_val;
                    vat = el.price * (vatVal / 100.0);
                }
                this.total_cost += el.price + vat;
            });
        },
        async report() {
            this.types = [];
            await axios
                .get(
                    "/RTypes?period=" +
                    this.period +
                    "&branch_id=" +
                    this.user.branch_id +
                    "&type_id=" +
                    this.type_id +
                    "&from=" +
                    this.from +
                    "&to=" +
                    this.to +
                    "&cat_id=" +
                    this.cat_id
                )
                .then((res) => {
                    res.data.forEach((type) => {
                        this.add(type);
                    });
                });
        },
    },
};
</script>
