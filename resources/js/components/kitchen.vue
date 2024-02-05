<template>
    <div v-if="bill ">
        <!-- <a
            id="kitchenBtn"
            class="btn btn-info text-light d-none"
            data-target="#tokitchenModal"
            data-toggle="modal"
            ><i class="fas fa-ellipsis-v"></i
        ></a> -->
        <div
            id="tokitchenModal"
            aria-hidden="true"
            aria-labelledby="tokitchenModal"
            class="modal fade"
            role="dialog"
            tabindex="-1"
            data-backdrop="static"
            data-keyboard="false"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                role="document"
            >
                <!-- <div class="modal-content m-auto" style="width: 350px;"> -->
                    <!-- <div class="modal-header">
                        <button
                            aria-label="Close"
                            class="close"
                            data-dismiss="modal"
                            type="button"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> -->
                    <div id="toKitchen" class="modal-body "  >
                        <div id="invoice-POS" class="pos-section">

                            <!--End InvoiceTop-->
                            <hr class="hr-line" />
                            <div id="bot">
                                <div id="table">
                                    <iframe
                                        id="printFrame"
                                        name="display-frame"
                                        style="width: 75mm; border: none;height:350px"
                                    ></iframe>
                                </div>
                                <!--End Table-->
                            </div>
                        </div>
                        <!--End Invoice-->
                    </div>

                    <div class="modal-footer text-center">
                        <button
                            id="print"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            type="button"
                        >
                            إغلاق
                        </button>
                        <a
                            id="distribute"
                            target="display-frame"
                            class="btn btn-success "
                            :href="'/printTokitchen/' + bill"
                            >طباعة</a
                        >

                        <button
                            id="kitchen"
                            class="btn btn-success d-none"
                            @click="kitchenOne()"
                        >
                            طباعة
                        </button>
                        <button class="btn btn-success  d-none" @click="kitchenOne()">
                            طباعة
                        </button>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
</template>

<script>
import { Invoice } from "@axenda/zatca";
import moment from "moment";
import Cookie from "../Helpers/Cookie";

export default {
    async created() {
         if (!User.loggedIn()) {
            this.$router.push("/");
        }
                let user = await Auth.getAuth();
        this.mixins = user.branch;

    },
    updated() {
        $("#distribute").click();
    },
    props: ["bill"],
    data() {
        return {
            isDone: false,
            mixins: {},
            moment: moment,
            isclicked: false,
            mydata: [],
        };
    },
    methods: {


        kitchenOne() {
            this.$htmlToPaper("toKitchen");
        },
    },
};
</script>

<style scoped></style>
