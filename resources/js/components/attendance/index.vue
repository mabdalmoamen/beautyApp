<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" onmousemove="$('input').focus();">
                    <a
                        class="nav-link active"
                        id="home-tab"
                        data-toggle="tab"
                        href="#home"
                        role="tab"
                        aria-controls="home"
                        aria-selected="true"
                        >{{ __("Attend") }}</a
                    >
                </li>
                <li class="nav-item" onmousemove="$('input').focus();">
                    <a
                        class="nav-link"
                        id="profile-tab"
                        data-toggle="tab"
                        href="#profile"
                        role="tab"
                        aria-controls="profile"
                        aria-selected="false"
                        >{{ __("Leave") }}</a
                    >
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div
                    class="tab-pane fade show active"
                    id="home"
                    role="tabpanel"
                    aria-labelledby="home-tab"
                >
                    <form
                        class="form-horizontal m-t-30"
                        @submit.prevent="create(true)"
                    >
                        <div class="form-group">
                            <input
                                id="code"
                                type="code"
                                class="form-control-sm"
                                v-model="form.code"
                                required
                                autofocus
                                @keyup="checkBarcodeEvent"
                            />
                        </div>
                    </form>
                    <table class="text-center table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __("User Name") }}</th>
                                <th>{{ __("Attendance Time") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(attendance, index) in attendances"
                                :key="index"
                            >
                                <td>{{ attendance.user.name }}</td>

                                <td>
                                    {{
                                        moment(attendance.created_at).format(
                                            "DD-MM-YYYY HH:MM:SS"
                                        )
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="tab-pane fade"
                    id="profile"
                    role="tabpanel"
                    aria-labelledby="profile-tab"
                >
                    <form
                        class="form-horizontal m-t-30"
                        @submit.prevent="create(false)"
                    >
                        <div class="form-group">
                            <input
                                id="code"
                                type="code"
                                class="form-control-sm"
                                v-model="form.code"
                                required
                                autofocus
                                @keyup="checkBarcodeEvent"
                            />
                        </div>
                    </form>
                    <table
                        class="table"
                        style="
                            border-collapse: collapse;
                            border-spacing: 0;
                            width: 100%;
                        "
                    >
                        <thead>
                            <tr>
                                <th>{{ __("User Name") }}</th>

                                <th>{{ __("Leave Time") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(leave, index) in leaves" :key="index">
                                <td>{{ leave.user.name }}</td>

                                <td>
                                    {{
                                        moment(leave.created_at).format(
                                            "DD-MM-YYYY HH:MM:SS"
                                        )
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
       this.user=await Auth.getAuth();

        await this.getAll();
    },
    data() {
        return {
            user: {},
            users: [],
            attendances: [],
            leaves: [],
            moment: moment,
            form: {
                code: "",
            },
        };
    },

    methods: {
        checkBarcodeEvent(e) {
            var string = "";
            var timeout;
            var lastEventTime = 0;

            // ADJUST THOSE TWO!
            var threshold = 35;
            var outputDelay = 100;
            e.preventDefault();
            var codebarInput = $(this);
            // Get current time.
            var thisEventTime = Date.now();

            // Grab the character.
            string += String.fromCharCode(e.keyCode);

            // If this event occurs sooner than the threshold delay, use the timeout to output the value when all characters are in string.
            if (lastEventTime + threshold > thisEventTime) {
                // Output the string after a delay.
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    codebarInput.val(string);
                }, outputDelay);

                // If this event occurs after the threshold delay, clear string and input value.
            } else {
                codebarInput.val("");
                string = "";
            }

            // Keep this event time.
            lastEventTime = thisEventTime;

            // End keydown
        },
        async getAll() {
            await axios
                .get("/api/attendance")
                .then(({ data }) => {
                    this.attendances = data.attendances;
                    this.users = data.users;
                    this.leaves = data.leaves;
                })
                .catch((error) => console.log(error));
        },
        async create(type) {
            this.form.attend = type;

            await axios
                .post("/api/attendance", this.form)
                .then(async ({ data }) => {
                    await this.getAll();
                    this.form.code = "";
                    this.form.attend = "";
                    Notification.successMsg(data.message);
                })
                .catch((error) => Notification.errorMsg(data.message));
        },
    },
};
</script>
<style></style>
