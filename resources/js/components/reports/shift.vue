<template>
    <div class="card mb-4" id="allReport">
        <div class="card-header d-flex flex-row align-items-center justify-content-between hideMeInPrint">

            <h1 class="text-center my-0 d-block">تقرير الشيفت</h1>
            <i class="fas fa-file-excel fa-2x text-success" style="cursor: pointer"
                onclick="download('xlsx','shifts');"></i>

            <button class="b tn btn-success " onclick="window.print()" type="submit">
                {{ __("Print") }}
            </button>

            <form class="needs-validation mt-2 hideMeInPrint" @submit.prevent="veiwReport">
                <div class="form-row">
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend input-sm">
                                <span class="input-group-text" id="validationTooltipUsernamePrepend">{{ __("From") }}</span>
                            </div>
                            <date-picker v-model="form" id="from" required :placeholder="__('From')">
                            </date-picker>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend float-right input-sm">
                                <span class="input-group-text" for="to">{{
                                    __("To")
                                }}</span>
                            </div>
                            <date-picker v-model="to" id="to" required :placeholder="__('To')">
                            </date-picker>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success" type="submit">
                            {{ __("View") }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body table-responsive-sm w-100 text-center">
            <table class="table table-hover table-sm table-striped" id="shifts">
                <thead>
                    <tr>
                        <th>تاريخ بداية الشيفت</th>
                        <th>مسئول الشيفت</th>
                        <th>مبلغ الدرج</th>

                        <th>المبلغ المحول</th>
                        <th>نقدي</th>
                        <th>اجل</th>
                        <th>بطاقة</th>
                        <th>عجز</th>
                        <th>زيادة</th>
                        <th>متبقي</th>
                        <th>تاريخ نهاية الشفت</th>
                        <th>الموظف المستلم</th>
                        <th>طباعة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(shift, index) in shifts" :key="index">
                        <td>{{ shift.starter_date }}</td>
                        <td>{{ shift.current_user.name }}</td>
                        <td>{{ format(shift.cash_entered) }}</td>

                        <td>{{ format(shift.transfer) }}</td>
                        <td>{{ format(shift.cash) }}</td>
                        <td>{{ format(shift.later) }}</td>
                        <td>{{ format(shift.card) }}</td>
                        <td :class="
                            shift.deficit > 0 ? 'bg-warning text-light' : ''
                        ">
                            {{ format(shift.deficit) }}
                        </td>
                        <td :class="
                            shift.increase > 0 ? 'bg-danger text-light' : ''
                        ">
                            {{ format(shift.increase) }}
                        </td>
                        <td>{{ format(shift.remain) }}</td>
                        <td>{{ shift.end_date }}</td>
                        <td>{{ shift.recived_user.name }}</td>
                        <td>
                            <button class="btn btn-info text-light" @click="showShift(shift)">
                                طباعة
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <shift :shift="shift"></shift>
        </div>

    </div>
</template>

<script>
import datePicker from "../date/index";
import shift from "./../shift/shift_print.vue";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import moment from "moment";

export default {
    components: { datePicker, shift },

    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        this.form = moment().add(-5, "days").format();
        this.to = moment().add(0, "days").format();

        await this.veiwReport();
        this.form = moment().add(-5, "days");
        this.to = moment().add(0, "days");

    },
    data() {
        return {
            configs: {
                wrap: {
                    allowInputToggle: true,
                },
            },
            shifts: [],
            shift: null,
            to: null,
            form: null,

        };
    },
    methods: {
        async showShift(shift) {
            this.shift = await shift;
            setTimeout(() => {
                $("#shiftBtn").click();
            }, 1000);
        },
        format(num) {
            return parseFloat(num).toFixed(this.$root.$data.codies.digit);
        },
        veiwReport() {
            this.form = moment(this.form).format();
            this.to = moment(this.to).format();

            axios
                .get("/api/shift/report/" + this.form + "/" + this.to)
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.loading = false;
                        this.shifts = data;
                    }
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style scoped></style>
