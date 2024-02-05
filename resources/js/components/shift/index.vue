<template>
    <section class="row">
        <section v-if="!loading" class="col-12">
            <div
                class="card-header text-center d-flex py-2 justify-content-between"
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
                <h5 class="font-weight-bold text-primary">
                    {{ __("تفاصيل الشيفت") }}
                </h5>
            </div>
            <div class="col-12 text-center">
                <div class="row">
                    <div class="col-6 col-auto px-0" v-if="isShift">
                        <div class="card m-2 m">
                            <div class="card-content">
                                <div class="card-body">
                                    <span class="float-start"
                                        >مسئول الشيفت</span
                                    >
                                    <span class="text-end">{{
                                        shift.current_user.name
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-auto px-0" v-if="isShift">
                        <div class="card m-2">
                            <div class="card-content">
                                <div class="card-body">
                                    <span class="float-start">
                                        تاريخ بداية الشيفت
                                    </span>
                                    <span class="text-end">{{
                                        shift.starter_date
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12 px-0">
                        <div class="card m-2">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="align-self-center">
                                        <b class="float-start"> نقدي </b>
                                    </div>
                                    <div class="text-end">
                                        <b>{{ format(shift.cash) }}</b>
                                        <span v-if="mixins.currency">{{
                                            mixins.currency.currency_ar
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12 px-0">
                        <div class="card m-2">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="align-self-center">
                                        <b class="float-start"> بطاقة </b>
                                    </div>
                                    <div class="text-end">
                                        <b>{{ format(shift.card) }}</b>
                                        <span v-if="mixins.currency">{{
                                            mixins.currency.currency_ar
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12 px-0">
                        <div class="card m-2">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="align-self-center">
                                        <b class="float-start"> آجلة </b>
                                    </div>
                                    <div class="text-end">
                                        <b>{{ format(shift.later) }}</b>
                                        <span v-if="mixins.currency">{{
                                            mixins.currency.currency_ar
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="row"
                    style="padding: 0 !important"
                    v-if="shift.starter_date != null"
                >
                    <div class="col-6 accordion-item px-0">
                        <div class="accordion-header" id="headingTwo">
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                style="padding: 5px !important"
                            >
                                <button
                                    class="collapsed btn btn-secondary font-weight-bold text-light"
                                    @click="endShift = !endShift"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo"
                                >
                                    {{ __("إنهاء الشيفت") }}
                                    <i
                                        v-if="endShift"
                                        class="fa fa-angle-double-down"
                                    ></i>
                                    <i v-else class="fa fa-angle-double-up"></i>
                                </button>
                            </div>
                        </div>
                        <div
                            id="collapseTwo"
                            :class="
                                endShift
                                    ? 'accordion-collapse collapse show'
                                    : 'accordion-collapse collapse'
                            "
                            aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample"
                        >
                            <div class="accordion-body">
                                <div v-if="isShift" class="card-body">
                                    <form @submit.prevent="saveChanges">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-auto">
                                                <!-- Form Basic -->
                                                <div class="card mb-4">
                                                    <div
                                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                                    >
                                                        <button
                                                            type="submit"
                                                            class="btn btn-primary"
                                                            :disabled="
                                                                shift.transfer <
                                                                0
                                                            "
                                                        >
                                                            حفظ
                                                        </button>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>
                                                                مبيعات الشيفت
                                                                نقدي
                                                            </label>
                                                            <input
                                                                onClick="this.select();"
                                                                required
                                                                type="number"
                                                                step="0.001"
                                                                min="0"
                                                                class="form-control"
                                                                v-model="cash"
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                >المبلغ المحول
                                                                للخزينة</label
                                                            >
                                                            <input
                                                                onClick="this.select();"
                                                                required
                                                                type="number"
                                                                class="form-control"
                                                                step="0.001"
                                                                min="0"
                                                                v-model="
                                                                    shift.transfer
                                                                "
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                >المبلغ المتبقي
                                                                للوردية
                                                                التالية</label
                                                            >
                                                            <input
                                                                onClick="this.select();"
                                                                type="number"
                                                                required
                                                                readonly="true"
                                                                step="0.001"
                                                                min="0"
                                                                disabled
                                                                class="form-control"
                                                                :value="
                                                                    cash -
                                                                    shift.transfer
                                                                "
                                                            />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                الموظف المستلم
                                                            </label>
                                                            <select
                                                                v-model="
                                                                    shift.recived_user
                                                                "
                                                                required
                                                                class="form-control"
                                                            >
                                                                <option
                                                                    v-for="(
                                                                        user,
                                                                        index
                                                                    ) in users"
                                                                    :key="index"
                                                                    :value="
                                                                        user.name
                                                                    "
                                                                >
                                                                    {{
                                                                        user.name
                                                                    }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                كلمة مرور الموظف
                                                                المستلم
                                                            </label>
                                                            <input
                                                                onClick="this.select();"
                                                                type="password"
                                                                class="form-control"
                                                                required
                                                                v-model="
                                                                    password
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ShiftPrint :shift="shift"></ShiftPrint>
        </section>
        <Spinner v-else></Spinner>
    </section>
</template>

<script>
import Security from "../spinner/security";
import Spinner from "../spinner/loading.vue";
import ShiftPrint from "./shift_print.vue";

export default {
    components: { Security, Spinner, ShiftPrint },

    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;

        await axios
            .get("/api/shift")
            .then(({ data }) => {
                if (data) {
                    this.isShift = true;
                    this.shift = data;
                }
            })
            .catch((err) => console.log(err));
        await this.getLastShift();
        await axios
            .get("/api/users")
            .then(({ data }) => (this.users = data))
            .catch((err) => console.log(err));
    },
    data() {
        return {
            user: {},
            endShift: false,
            isShift: false,
            loading: true,
            shift: {
                current_user: null,
                recived_user: null,
                starter_point: 0.0,
                cash: 0.0,
                later: 0.0,
                card: 0.0,
                transfer: 0.0,
                increase: 0.0,
                remain: 0.0,
                deficit: 0.0,
                starter_date: null,
                end_date: null,
                drawerCash: 0.0,
            },
            cash: 0.0,
            password: null,
            transfer: 0.0,
            users: [],
            mixins: {},
            period: "period",
            types: [],
            total_cost: 0.0,
        };
    },
    methods: {
        format(num) {
            return parseFloat(num).toFixed(this.mixins.digit);
        },
        async getLastShift() {
            await axios
                .get("/api/bill/shift")
                .then(({ data }) => {
                    if (data && this.shift.starter_date === null) {
                        this.shift.cash = data;
                    }
                    this.loading = false;
                })
                .catch((err) => console.log(err));
        },
        async saveChanges() {
            let is_Valid = true;

            if (this.cash - this.shift.transfer < 0) {
                await Notification.errorMsg(
                    "المبلغ المحول للخزينة أكبر من مبيعات الشيف1ت"
                );
                is_Valid = false;
            }
            if (parseInt(this.shift.transfer) > parseInt(this.cash)) {
                await Notification.errorMsg(
                    "المبلغ المحول للخزينة أكبر من مبيعات الشي2فت"
                );
                is_Valid = false;
            }
            if (is_Valid) {
                await this.save();
            }
        },
        async save() {
            this.shift.remain = this.cash - this.shift.transfer;
            this.shift.name = this.shift.recived_user;
            this.shift.password = this.password;
            this.shift.drawerCash = this.cash;
            await axios
                .patch("/api/shift/" + this.shift.id, this.shift)
                .then(async (data) => {
                    Notification.success();
                    this.shift = data.data;
                    this.isShift = false;
                })
                .then(async () => {
                    await $("#shiftBtn").click();
                    await this.getLastShift();
                })
                .catch((error) => {
                    Notification.errorMsg(error.response.data.error);
                });
        },
        add(type) {
            this.total_cost = 0.0;
            let count = type.type_count;
            let rQty = type.total_return_qty;
            count -= rQty;
            let price = count * type.type_price;
            const found = this.types.some(
                (el) => el.type.type_id === type.type_id
            );
            if (!found) {
                this.types.push({ price, count, type: type.type });
            } else {
                this.types.filter((el) => {
                    let vat = 0;

                    if (
                        !this.mixins.mixins_price_include_vat &&
                        this.mixins.fixed_vat
                    ) {
                        let vatVal = this.mixins.mixins_vat_val;
                        vat = price * (vatVal / 100.0);
                    }
                    if (el.type.type_id === type.type_id) {
                        el.count += count;
                        el.price += price + vat;
                    }
                });
            }
            for (let i = 0; i < this.types.length; i++) {
                let vat = 0;

                if (
                    !this.mixins.mixins_price_include_vat &&
                    this.mixins.fixed_vat
                ) {
                    let vatVal = this.mixins.mixins_vat_val;
                    vat = this.types[i].price * (vatVal / 100.0);
                }
                this.total_cost += this.types[i].price + vat;
            }
        },
    },
};
</script>
<style scoped>
input.num {
    min-width: 20%;
}
</style>
