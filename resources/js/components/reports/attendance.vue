<template>
    <div>
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
                <div class="modal-content m-auto" style="min-width: 500px">
                    <div class="modal-header">
                        <button
                            aria-label="Close"
                            class="close"
                            data-dismiss="modal"
                            type="button"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive ">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __("User Name") }}
                                    </th>

                                    <th>
                                        {{ __("Select") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in users" :key="index">
                                    <td>{{ user.name }}</td>

                                    <td>
                                        <button
                                            class="btn btn-success btn-sm"
                                            data-dismiss="modal"
                                            @click="selectUser(user)"
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
                    <div class="modal-footer">
                        <button
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            type="button"
                        >
                            {{ __("Close") }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="allReport">
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <tr>
                    <td class="h6 td-no-border">
                        {{ __("Attendance And Leave report") }}
                    </td>
                    <td class="td-no-border">
                        <i
                            class="fas fa-2x fa-file-excel text-success mt-1 mb-0"
                            style="cursor: pointer; text-align: center"
                            onclick="download('xlsx','attendances');"
                        ></i>
                    </td>
                    <td class="td-no-border">{{ __("Code") }}</td>
                    <td class="td-no-border">
                        <input
                            style="width: 100px"
                            v-model="search"
                            class="from-control-sm"
                            type="text"
                            @keyup="findUser"
                        />
                    </td>
                    <td class="td-no-border">
                        {{ __("User Name") }}
                    </td>
                    <td class="td-no-border">
                        <input
                            :value="user.name"
                            class="from-control-sm"
                            placeholder=""
                            type="text"
                        />
                    </td>
                    <td class="td-no-border">
                        <a
                            class="btn btn-info btn-sm text-light"
                            data-target="#exampleModal"
                            data-toggle="modal"
                            ><i
                                class="fas fa-search font-weight-bold text-light"
                            ></i
                        ></a>
                    </td>
                    <td class="td-no-border">
                        {{ __("Report") }}
                    </td>
                    <td class="td-no-border">
                        <select
                            id="inputState"
                            v-model="reportPeriod.period"
                            class="form-control-sm text-center"
                        >
                            <option value="daily">
                                {{ __("Daily") }}
                            </option>
                            <option value="monthly">
                                {{ __("Monthly") }}
                            </option>
                            <option value="Period">
                                {{ __("Period") }}
                            </option>
                        </select>
                    </td>
                    <td class="td-no-border">
                        <button
                            class="btn btn-success"
                            onclick="window.print()"
                            type="submit"
                        >
                            {{ __("Print") }}
                        </button>
                    </td>
                </tr>
                <form class="hideMeInPrint" @submit.prevent="viewReport">
                    <div class="form-row">
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-prepend input-sm">
                                    <span for="from" class="input-group-text">{{
                                        __("From")
                                    }}</span>
                                </div>
                                <date-picker
                                    v-model="reportPeriod.from"
                                    id="from"
                                    :wrap="true"
                                    :config="configs.wrap"
                                    :placeholder="__('From')"
                                >
                                </date-picker>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <div
                                    class="input-group-prepend float-right input-sm"
                                >
                                    <span class="input-group-text" for="to">{{
                                        __("To")
                                    }}</span>
                                </div>
                                <date-picker
                                    v-model="reportPeriod.to"
                                    id="to"
                                    :wrap="true"
                                    :config="configs.wrap"
                                    :placeholder="__('To')"
                                >
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
            <div class="card-body">
                <div v-for="(u, index) in users" >
                    <h1 class="h6 float-right">
                        {{ u.name }}
                    </h1>
                    <table id="attendances" class="text-center table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __("Attendance Time") }}</th>
                                <th>{{ __("Leave Time") }}</th>
                                <th>{{ __("Hour Count") }}</th>
                            </tr>
                        </thead>
                        <tbody v-if="u.attendances.length != 0">
                            <tr v-for="(attendance, i) in u.attendances">
                                <td>
                                    {{
                                        moment(attendance.created_at).format(
                                            "DD-MM-YYYY HH:MM:SS"
                                        )
                                    }}
                                </td>
                                <td>
                                    {{
                                        attendance.leave_date
                                            ? moment(
                                                  attendance.leave_date
                                              ).format("DD-MM-YYYY HH:MM:SS")
                                            : "---"
                                    }}
                                </td>
                                <td :class="u.name.replace(/\s/g, '')">
                                    {{
                                        parseFloat(
                                            attendance.late_over
                                        ).toFixed("2")
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <hr />
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="3">
                                    {{ __("Has't Attend") }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot v-if="u.attendances.length != 0">
                            <tr>
                                <td colspan="2">
                                    {{ __("Total Work Hours") }}
                                </td>
                                <td>
                                    {{ count(u.name) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">{{ __("Salary") }}</td>
                                <td>
                                    {{
                                        parseFloat(
                                            count(u.name) * u.hour_price
                                        ).toFixed("2")
                                    }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Bills from "./bills";
import Cash from "./cash";
import datePicker from "../date/index";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import moment from "moment";

export default {
    components: { Bills, Cash, datePicker },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        await this.viewReport();
    },
    data() {
        return {
            bills: [],
            showCash: false,

            period: false,
            hideMe: false,
            reportPeriod: {
                to: null,
                from: null,
                period: "monthly",
            },
            moment: moment,
            configs: {
                wrap: {
                    allowInputToggle: true,
                },
            },
            user: {},
            users: "",
            search: "",
            attendance: [],
        };
    },
    methods: {
        count(cls) {
            let slider = $("." + cls.replace(/\s/g, "")),
                sliderArr = Array.from(slider);

            let total = 0;
            slider.each(function () {
                total += parseFloat($(this).html()).toFixed("2");
            });

            return parseFloat(total).toFixed("2");
        },
        selectUser(user) {
            this.user = user;
            this.search = user.id;
        },
        async findUser() {
            await axios
                .get("/api/users/" + this.search)
                .then(({ data }) => {
                    this.user = data;
                })
                .catch((error) => console.log(error));
        },
        async viewReport() {
            await this.allUserAttendance();
            await this.allUserAttendance();
        },
        allUserAttendance() {
            axios
                .get(
                    "/api/attendance/report/" +
                        this.reportPeriod.period +
                        "/" +
                        this.reportPeriod.from +
                        "/" +
                        this.reportPeriod.to +
                        "/" +
                        this.user.id
                )
                .then(({ data }) => {
                    // this.loading = false;
                    this.users = data.users;
                })
                .catch((error) => console.log(error));
        },

        hideMeInPrint() {
            this.hideMe = !this.hideMe;
        },
    },
};
</script>
<style>
input {
    border: 1px solid #c4c4c4;
    border-radius: 5px;
    background-color: #fff;
    padding: 3px 5px;
    box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
}

@media print {
    .hideMeInPrint {
        display: none;
    }
}
</style>
