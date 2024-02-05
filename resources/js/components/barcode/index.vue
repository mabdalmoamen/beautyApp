<template>
    <div class="card">
        <div
            class="card-header d-flex flex-row align-items-center justify-content-between"
        >
            <a class="btn btn-warning text-light" @click="$router.go(-1)">
                <i
                    :class="
                        $root.$data.codies.default_lang == 'ar'
                            ? 'fa fa-arrow-right'
                            : 'fa fa-arrow-left'
                    "
                ></i>
            </a>
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __("Barcode Settings") }}
            </h6>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input
                        type="checkbox"
                        class="custom-control-input"
                        id="codeType"
                        v-model="isForTypes"
                        @change="getBarcode()"
                    />
                    <label class="custom-control-label" for="codeType">
                        {{ __("Types") }}
                    </label>
                </div>
            </div>
            <button
                class="btn btn-sm btn-info"
                @click="showSearchTypeModal = true"
            >
                <i class="fa fa-search font-weight-bold text-light"></i>
            </button>
        </div>
        <div class="container text-center">
            <div
                :class="
                    showSearchTypeModal
                        ? 'modal fade show d-block modaldrg'
                        : 'modal fade modaldrg'
                "
                aria-hidden="true"
                aria-labelledby="exampleModalLabel"
                role="dialog"
                tabindex="-1"
            >
                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document"
                >
                    <div class="modal-content m-auto" style="min-width: 850px">
                        <div class="modal-header">
                            <h5 class="modal-title" i>{{ __("Types") }}</h5>
                            <button
                                aria-label="Close"
                                class="close"
                                data-dismiss="modal"
                                type="button"
                            >
                                <span
                                    aria-hidden="true"
                                    @click="
                                        searchTypes = [];
                                        showSearchTypeModal = false;
                                    "
                                    >&times;</span
                                >
                            </button>
                        </div>
                        <div
                            class="modal-body min-h-50 table-responsive"
                            style="min-height: 500px; overflow: auto"
                        >
                            <input
                                v-model="typeName"
                                class="form-control-sm"
                                :placeholder="__('Type Name')"
                                type="search"
                                @keyup="findTypeByLike()"
                            />
                            <button
                                class="btn btn-sm btn-info"
                                @click="findTypeByLike()"
                            >
                                <i
                                    class="fa fa-search font-weight-bold text-light"
                                ></i>
                            </button>
                            <table
                                class="text-center"
                                style="
                                    position: absolute;
                                    z-index: 999;
                                    overflow: auto;
                                "
                            >
                                <thead>
                                    <tr>
                                        <th style="width: 10%">
                                            {{ __("Code") }}
                                        </th>
                                        <th style="width: 50%">
                                            {{ __("Type Name") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Price") }}
                                        </th>
                                        <th style="width: 10%">
                                            {{ __("Select") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(
                                            searchType, index
                                        ) in searchTypes"
                                        :key="index"
                                    >
                                        <td>{{ searchType.type_id }}</td>
                                        <td>{{ searchType.type_name_ar }}</td>
                                        <td>
                                            {{ searchType.type_sill_price }}
                                        </td>
                                        <td>
                                            <i
                                                class="fa fa-plus btn-sm btn-success font-weight-bold text-light"
                                                @click="selectType(searchType)"
                                            ></i>
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
                                @click="
                                    searchTypes = [];
                                    typeName = '';
                                    showSearchTypeModal = false;
                                "
                            >
                                {{ __("Close") }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="printMe">
                <img id="barcode" />
            </div>

            <form class="types" dir="rtl" @submit.prevent="create">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Barcode</p>
                                    </div>
                                    <div class="col-6">
                                        <input
                                            @change="fireBrcode"
                                            class="form-control"
                                            id="userInput"
                                            type="text"
                                            v-model="barcode.text"
                                            placeholder="Barcode"
                                            autofocus=""
                                        />
                                    </div>
                                </div>
                                <!-- Bar width -->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Bar Width</p>
                                    </div>
                                    <div class="col-6">
                                        <input
                                            class="form-range"
                                            v-model="barcode.width"
                                            @change="fireBrcode"
                                            type="range"
                                            min="1"
                                            max="4"
                                            step="1"
                                        />
                                    </div>
                                    <div class="col-2">
                                        <p>
                                            <span id="bar-height-display">{{
                                                barcode.width
                                            }}</span>
                                        </p>
                                    </div>
                                </div>
                                <!-- Height -->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Height</p>
                                    </div>
                                    <div class="col-6">
                                        <input
                                            @change="fireBrcode"
                                            class="form-range"
                                            v-model="barcode.height"
                                            type="range"
                                            min="10"
                                            max="150"
                                            step="5"
                                        />
                                    </div>
                                    <div class="col-2">
                                        <p>
                                            <span id="bar-height-display">{{
                                                barcode.height
                                            }}</span>
                                        </p>
                                    </div>
                                </div>
                                <!-- Margin -->
                                <div class="row mb-2 d-none">
                                    <div class="col-4">
                                        <p>Margin</p>
                                    </div>
                                    <div class="col-6">
                                        <input
                                            @change="fireBrcode"
                                            class="form-range"
                                            v-model="barcode.margin"
                                            type="range"
                                            min="0"
                                            max="9"
                                            step="1"
                                        />
                                    </div>
                                    <div class="col-2">
                                        <p>
                                            <span id="bar-margin-display">{{
                                                barcode.margin
                                            }}</span>
                                        </p>
                                    </div>
                                </div>
                                <!-- Font size -->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Font Size</p>
                                    </div>
                                    <div class="col-6">
                                        <input
                                            @change="fireBrcode"
                                            class="form-range"
                                            v-model="barcode.fontSize"
                                            type="range"
                                            min="8"
                                            max="36"
                                            step="1"
                                        />
                                    </div>
                                    <div class="col-2">
                                        <p>
                                            <span id="bar-fontSize-display"
                                                >{{ barcode.fontSize }}px</span
                                            >
                                        </p>
                                    </div>
                                </div>
                                <!-- Text margin -->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Text Margin</p>
                                    </div>
                                    <div class="col-6">
                                        <input
                                            @change="fireBrcode"
                                            class="form-range"
                                            v-model="barcode.textMargin"
                                            type="range"
                                            min="-15"
                                            max="40"
                                            step="1"
                                        />
                                    </div>
                                    <div class="col-2">
                                        <p>
                                            <span
                                                id="bar-text-margin-display"
                                                >{{ barcode.textMargin }}</span
                                            >
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>barcode format</p>
                                    </div>
                                    <div class="col-6">
                                        <select
                                            class="form-control-sm text-center w-100"
                                            v-model="barcode.format"
                                            @change="fireBrcode"
                                            id="barcodeType"
                                            title="CODE128"
                                        >
                                            <option value="CODE128">
                                                CODE128
                                            </option>
                                            <option value="CODE128A">
                                                CODE128 A
                                            </option>
                                            <option value="CODE128B">
                                                CODE128 B
                                            </option>
                                            <!--                                <option value="CODE128C">CODE128 C</option>-->
                                            <!--                                <option value="EAN13">EAN13</option>-->
                                            <!--                                <option value="EAN8">EAN8</option>-->
                                            <!--                                <option value="UPC">UPC</option>-->
                                            <option value="CODE39">
                                                CODE39
                                            </option>
                                            <!-- <option value="itf14">ITF14</option> -->
                                            <!--                                <option value="ITF">ITF</option>-->
                                            <option value="MSI">MSI</option>
                                            <option value="MSI10">MSI10</option>
                                            <option value="MSI11">MSI11</option>
                                            <option value="MSI1010">
                                                MSI1010
                                            </option>
                                            <!--                                <option value="MSI1110">MSI1110</option>-->
                                            <option value="pharmacode">
                                                Pharmacode
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>text Position</p>
                                    </div>
                                    <div class="col-6">
                                        <select
                                            class="form-control-sm text-center w-100"
                                            @change="fireBrcode"
                                            v-model="barcode.textPosition"
                                            role="toolbar"
                                        >
                                            <option value="bottom">
                                                Bottom
                                            </option>
                                            <option value="top">Top</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Show text -->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Show text</p>
                                    </div>
                                    <div class="col-6">
                                        <select
                                            class="form-control-sm text-center w-100"
                                            @change="fireBrcode"
                                            v-model="barcode.displayValue"
                                            role="toolbar"
                                        >
                                            <option value="1">Show</option>
                                            <option value="0">Hide</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Text align -->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Text Align</p>
                                    </div>
                                    <div class="col-6 center-text">
                                        <select
                                            v-model="barcode.textAlign"
                                            @change="fireBrcode"
                                            class="form-control-sm text-center w-100"
                                            role="toolbar"
                                        >
                                            <option value="left">Left</option>
                                            <option
                                                type="button"
                                                class="btn btn-default btn-primary text-align"
                                                value="center"
                                            >
                                                Center
                                            </option>
                                            <option value="right">Right</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <!-- Font -->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Font</p>
                                    </div>
                                    <div class="col-6 center-text">
                                        <select
                                            class="form-control-sm text-center w-100"
                                            @change="fireBrcode"
                                            v-model="barcode.font"
                                            id="font"
                                            style="font-family: monospace"
                                        >
                                            <option
                                                value="monospace"
                                                style="font-family: monospace"
                                                selected="selected"
                                            >
                                                Monospace
                                            </option>
                                            <option
                                                value="sans-serif"
                                                style="font-family: sans-serif"
                                            >
                                                Sans-serif
                                            </option>
                                            <option
                                                value="serif"
                                                style="font-family: serif"
                                            >
                                                Serif
                                            </option>
                                            <option
                                                value="fantasy"
                                                style="font-family: fantasy"
                                            >
                                                Fantasy
                                            </option>
                                            <option
                                                value="cursive"
                                                style="font-family: cursive"
                                            >
                                                Cursive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Font options -->
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <p>Font Options</p>
                                    </div>
                                    <div class="col-6 center-text">
                                        <select
                                            @change="fireBrcode"
                                            class="form-control-sm text-center w-100"
                                            v-model="barcode.fontOptions"
                                            role="toolbar"
                                        >
                                            <option
                                                type="button"
                                                value="normal"
                                                style="font-weight: normal"
                                            >
                                                Normal
                                            </option>
                                            <option
                                                type="button"
                                                value="bold"
                                                style="font-weight: bold"
                                            >
                                                Bold
                                            </option>
                                            <option
                                                value="italic"
                                                style="font-style: italic"
                                            >
                                                Italic
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    {{ __("Save") }}
                </button>
                <button type="button" class="btn btn-success" @click="print">
                    {{ __("Print") }}
                </button>
            </form>
        </div>
    </div>
</template>
<script>
import JsBarcode from "jsbarcode";

export default {
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        await axios
            .get("/api/barcodes/" + 1)
            .then(({ data }) => {
                this.barcode = data;
            })
            .catch((error) => console.log(error));
        await this.fireBrcode();
    },
    data() {
        return {
            showSearchTypeModal: false,
            barcode: {},
            searchTypes: [],
            typeName: "",
            id: 1,
            isForTypes: true,
        };
    },
    methods: {
        selectType(type) {
            let barcode = type.type_barcode;
            if (
                type.type_barcode == null ||
                type.type_barcode == "" ||
                type.type_barcode.length == 0
            ) {
                barcode = type.type_id;
            }
            this.barcode.text = barcode;
            this.showSearchTypeModal = false;
            this.fireBrcode();
        },
        async findTypeByLike() {
            await axios
                .get("/api/action/like/" + this.typeName)
                .then(({ data }) => {
                    this.searchTypes = data;
                })
                .catch((error) => console.log(error));
        },
        print() {
            this.$htmlToPaper("printMe");
        },
        create() {
            axios
                .patch("/api/barcodes/" + this.id, this.barcode)
                .then(() => {
                    this.$router.push({ name: "home" });
                    Notification.success();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getBarcode() {
            this.id = 1;
            if (!this.isForTypes) {
                this.id = 2;
            }
            await axios
                .get("/api/barcodes/" + this.id)
                .then(({ data }) => {
                    this.barcode = data;
                })
                .catch((error) => console.log(error));
            await this.fireBrcode();
        },
        fireBrcode() {
            let show = false;
            if (this.barcode.displayValue >= 1) {
                show = true;
            }
            JsBarcode("#barcode", this.barcode.text, {
                textAlign: this.barcode.textAlign,
                textPosition: this.barcode.textPosition,
                font: this.barcode.font,
                fontOptions: this.barcode.fontOptions,
                textMargin: this.barcode.textMargin,
                text: this.barcode.text,
                format: this.barcode.format,
                displayValue: show,
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
        },
    },
    mounted() {
        this.fireBrcode();
    },
};
</script>
