<template>
    <div>
        <Spinner v-if="loading" :title="title"></Spinner>
        <div v-if="open_table" class="card text-center">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <p>
                        {{ __("Bookings Cards") }}
                    </p>
                    <button class="btn btn-secondary" type="button" @click="open_table = !open_table">
                        {{ __("Cancel") }}
                    </button>
                </div>
            </div>
            <div class="row text-center">
                <div class="card w-100">
                    <div class="card-body table-responsive">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th>{{ __("ID") }}</th>
                                    <th>{{ __("Customer Name") }}</th>
                                    <th>{{ __("Date") }}</th>
                                    <th>العربون</th>
                                    <th>{{ __("Notes") }}</th>
                                    <th>{{ __("Settings") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in bookings" :key="index">
                                    <td>{{ item.id }}</td>
                                    <td>
                                        {{
                                            item.customer
                                            ? item.customer.cust_name
                                            : ""
                                        }}
                                    </td>
                                    <td>{{ item.bill_date }}</td>
                                    <td>{{ item.bill_paid_val }}</td>
                                    <td>{{ item.bill_notes }}</td>
                                    <td>
                                        <button class="btn btn-success" @click="saveBook(item)">
                                            {{ __("Save") }}
                                        </button>
                                        <button class="btn btn-success" @click="editBook(item)">
                                            {{ __("Edit") }}
                                        </button>
                                        <!-- Button trigger modal -->
                                        <button :data-target="'#exampleModalCenter-' + item.id
                                            " class="btn p-2 btn-info text-light" data-toggle="modal" type="button">
                                            {{ __("View") }}
                                        </button>
                                        <div :id="'exampleModalCenter-' + item.id
                                            " aria-hidden="true" aria-labelledby="exampleModalCenterTitle"
                                            class="modal fade w-100" role="dialog" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered w-100"
                                                style="
                                                                                                                                            min-width: 90vw !important;
                                                                                                                                        " role="document">
                                                <div class="modal-content w-100">
                                                    <div class="card w-100">
                                                        <div class="card-header">
                                                            <div
                                                                class="d-flex align-content-between justify-content-between">
                                                                {{
                                                                    item.customer
                                                                    ? item
                                                                        .customer
                                                                        .cust_name
                                                                    : ""
                                                                }}
                                                            </div>
                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <table class="table text-center">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "Code"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "Type Name"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "Worker Name"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "Table Number"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "commission"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "reserve_date"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "end_reserve_date"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "Unit"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "Total"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                        <th>
                                                                            {{
                                                                                __(
                                                                                    "Notes"
                                                                                )
                                                                            }}
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="type in item.table_type" :key="type.table_type_id
                                                                        ">
                                                                        <td>
                                                                            {{
                                                                                type.type_id
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                type
                                                                                    .type
                                                                                    .type_name_ar
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                type.worker
                                                                                ? type
                                                                                    .worker
                                                                                    .name
                                                                                : ""
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                type.chair
                                                                                ? type
                                                                                    .chair
                                                                                    .table_no
                                                                                : ""
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                type.commission
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                type.reserve_date
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                type.end_reserve_date
                                                                            }}
                                                                        </td>

                                                                        <td>
                                                                            {{
                                                                                type.units
                                                                                ? type
                                                                                    .units
                                                                                    .unit
                                                                                    .unit_ar_name
                                                                                : "-"
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                type.type_total_price
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                type.type_note
                                                                            }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer py-1">
                                                        <button class="btn-sm btn btn-secondary" data-dismiss="modal"
                                                            type="button">
                                                            إغلاق
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <Booking :bill="item" v-if="mixins.bill_type = 'ar'" />
                                        <Booking-ar-en :bill="item" v-else />
                                        <button class="btn p-2 font-weight-bold btn-warning text-dark"
                                            @click="cancel(item)">
                                            {{ __("Cancel") }}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div v-else v-show="!loading && mixins">
            <!-- New Customer -->
            <div :class="add_newCutomser ? 'modal fade show d-block modaldrg' : 'modal  modaldrg'" id="newCustomer"
                role="dialog" aria-labelledby="newCustomerTitle">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <form class="user w-100" @submit.prevent="create">
                            <div class="modal-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            {{ __("Customer Name") }}</span>
                                    </div>
                                    <input class="form-control" v-model="customer.cust_name" type="text" />
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            {{ __("Customer Note") }}</span>
                                    </div>
                                    <input class="form-control" v-model="customer.notes" type="text" />
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            {{
                                                __("Customer identity")
                                            }}</span>
                                    </div>
                                    <input class="form-control" v-model="customer.identity" type="text" />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{
                                            __("Address")
                                        }}</span>
                                    </div>
                                    <input class="form-control" v-model="customer.cust_address" type="text" />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{
                                            __("mobile")
                                        }}</span>
                                    </div>
                                    <input class="form-control" v-model="customer.cust_mobile" type="text" />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            {{
                                                __("Customer Vat Number")
                                            }}</span>
                                    </div>
                                    <input class="form-control" v-model="customer.cust_vat_num" type="text" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Save") }}
                                </button>
                                <a id="closeDlg" @click="add_newCutomser = false" type="button" class="btn btn-danger"
                                    data-dismiss="modal">
                                    {{ __("Close") }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="alert alert-info" v-if="show_alert">
                <p class="text-right">
                    {{ mixins.info_text }}
                    <a href="#" class="float-left" @click.prevtype="show_alert = false">
                        <i class="fa fa-close"></i>
                    </a>
                </p>
            </div>
            <div class="card-header p-0">
                <!-- @submit.prevent="saveBill" -->
                <form>
                    <div class="row">
                        <div class="col-10 text-center">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="bg-success">
                                            <a :title="customer.cust_balance" class="text-light d-block"
                                                data-target="#exampleModal" data-toggle="modal" @click="allCustomers()"><i
                                                    class="fa fa-search px-1"></i>{{ __("Customer Code") }}</a>
                                        </th>
                                        <th data-toggle="modal" @click="add_newCutomser = !add_newCutomser">
                                            <i id="isNewCustomer" class="fa fa-plus">
                                            </i>
                                            {{ __("Customer Name") }}
                                        </th>

                                        <th>
                                            {{ __("Pay Methods") }}
                                        </th>
                                        <th v-show="form.pay !== 4">
                                            <Calculator />
                                            {{ __("Paid") }}
                                        </th>
                                        <th v-show="form.pay !== 4">
                                            {{ __("Remain") }}
                                        </th>
                                        <th v-show="form.pay == 4">
                                            {{ __('retainer') }}
                                        </th>
                                        <th v-show="form.pay == 4">
                                            <Calculator />
                                            {{ __("Paid Cash") }}
                                        </th>

                                        <th v-show="form.pay == 4">
                                            {{ __("Paid Card") }}
                                        </th>
                                        <th>{{ __("Sum") }}</th>
                                        <th>
                                            {{ __("Barcode") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input v-model="search" class="py-1 w-100" type="text"
                                                @keyup="findCustomer()" />
                                        </td>

                                        <td>
                                            <input :value="customer.cust_name" class="py-1 w-100" type="text" readonly />
                                        </td>

                                        <td>
                                            <select id="inputState" v-model="form.pay" class="py-1 w-100 text-center w-100"
                                                @change="calcTotal()">
                                                <option
                                                    v-for="(
                                                                                                                                                pay, index
                                                                                                                                            ) in payMethods"
                                                    :key="index" :value="pay.id">
                                                    {{ pay.pay_method_name }}
                                                </option>
                                            </select>
                                        </td>

                                        <td v-show="form.pay !== 4">
                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.paid" class="py-1 w-100 text-center" @change="calcRemain()" />
                                        </td>

                                        <td v-show="form.pay !== 4">
                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.remain" class="py-1 w-100 float-left text-center" readonly />
                                        </td>
                                        <td v-show="form.pay == 4">
                                            <input onClick="this.select();" type="checkbox" v-model="form.retainer"
                                                class="py-1 w-100 text-center" @change="retainerFunc()" />

                                        </td>
                                        <td v-show="form.pay == 4">
                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.cash" class="py-1 w-100 text-center"
                                                @change="calcPaidCash()" />
                                        </td>

                                        <td v-show="form.pay == 4">

                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.card" class="py-1 w-100 float-left text-center"
                                                :readonly="!form.retainer" @change="retainerFunc()" />
                                        </td>

                                        <td>
                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.sum" class="py-1 w-100 float-left text-center" readonly />
                                        </td>
                                        <td>
                                            <input id="barcode" v-model="barcode" class="form-control-sm"
                                                :placeholder="__('Barcode')" type="search" autofocus @change="findType()"
                                                onclick="event.preventDefault();this.select();"
                                                onchange="event.preventDefault();" onkeyup="event.preventDefault();" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <th v-if="mixins.active_point && customer.points">
                                            {{ __("pay_from_points") }}
                                        </th>
                                        <th v-if="mixins.active_point && customer.points">
                                            {{ __("points_equal") }}
                                        </th>
                                        <th v-show="user.bill_discount">
                                            {{ __("Discount") }}
                                            %
                                        </th>
                                        <th v-show="user.bill_extra">
                                            {{ __("Extra") }}
                                        </th>
                                        <th v-show="mixins.mixins_vat_val > 0">
                                            {{ __("Vat") }}
                                        </th>
                                        <th>{{ __("Total") }}</th>
                                        <th>{{ __("Notes") }}</th>

                                        <th>
                                            {{ __("Simple Code") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td v-if="mixins.active_point && customer.points">
                                            <input type="checkbox" v-model="form.pay_from_points" class="form-check" />
                                        </td>
                                        <td v-if="mixins.active_point && customer.points">{{ customer.points *
                                            mixins.point_price }}
                                        </td>
                                        <td v-show="user.bill_discount">
                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.discount" class="py-1 w-100 float-left text-center"
                                                @change="calcSum()" />
                                        </td>

                                        <td v-show="user.bill_extra">
                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.extra" class="py-1 w-100 float-left text-center"
                                                @change="calcSum()" />
                                        </td>

                                        <td v-show="mixins.mixins_vat_val > 0">
                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.vat" class="py-1 w-100 float-left text-center" readonly />
                                        </td>

                                        <td>
                                            <input onClick="this.select();" type="number" min="0" step="0.01"
                                                v-model="form.total" class="py-1 w-100 float-left text-center" readonly />
                                        </td>
                                        <td>
                                            <input type="text" v-model="form.note" class="py-1 w-100"
                                                :placeholder="__('Notes')" />
                                        </td>

                                        <td>
                                            <input v-model="id" class="py-1 w-100" :placeholder="__('Simple Code')"
                                                type="search" @change="findTypeByCodeOrId()" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2 text-center">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <span>
                                        <a :disabled="cart.length <= 0 || disable
                                            " class="btn w-100 d-block font-weight-bold btn-outline-warning text-dark"
                                            @click="saveToTable(false)">{{ __("PrintOnly") }}</a>
                                        <a :disabled="cart.length <= 0 || disable
                                            " class="btn w-100 font-weight-bold btn-outline-warning text-dark"
                                            @click="saveToTable(true)">{{ __("Notify") }}</a>
                                        <a class="btn w-100 font-weight-bold btn-outline-warning text-dark"
                                            @click="open_table = !open_table">
                                            {{
                                                open_table
                                                ? __("Cancel")
                                                : __("Bookings")
                                            }}
                                        </a>
                                    </span>
                                </div>
                                <div class="col-6">
                                    <i v-if="disable"
                                        class="btn w-100 d-block btn-outline-success font-weight-bold text-dark fa fa-spinner"></i>
                                    <a v-else title="CTRL+S" id="save" :disabled="cart.length <= 0 || disable"
                                        class="save btn btn-outline-success font-weight-bold text-dark" @click="saveBill">
                                        {{ __("Print") }}
                                        <small>CTRL+S</small>
                                    </a>

                                    <a id="reset" class="btn w-100 d-block font-weight-bold btn-outline-warning text-dark"
                                        @click="clearAll()">{{ __("Reset") }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--Start Calculation-->
            <div class="row mb-3 newBill card-body px-0 min-vh-50" @click="calc = false">
                <div class="col-6">
                    <!--Start Selected Items-->
                    <div class="selected" style="border: 1px solid #ddd">
                        <div class="card-header py-0 inbill text-center">
                            <p class="h6">{{ __("Bill Types") }}</p>
                        </div>
                        <div id="accordionExample">
                            <div class="m-0 p-0" v-for="( product, index ) in  cart " :key="product.id" :class="product.has_Offer
                                ? 'bg-secondary text-light'
                                : ''
                                ">
                                <div class="border-0 w-100 text-center d-flex justify-content-between border-0 text-right"
                                    :id="'headingOne' + index">
                                    <a v-if="product.type_count <= product.weight
                                        " class="btn btn-danger" @click="removeFromCart(product, index)"><i
                                            class="fa fa-trash text-light"></i>
                                    </a>
                                    <button v-if="mixins.bill_lang == 'ar'"
                                        class="btn btn-success btn-link btn-block text-center" type="button"
                                        data-toggle="collapse" :data-target="'#collapseOne' + index"
                                        :aria-controls="'collapseOne' + index">
                                        {{
                                            mixins.default_lang == "en" &&
                                            product.type_name_en != "" &&
                                            product.type_name_en != null
                                            ? product.type_name_en
                                            : product.type_name_ar
                                        }}
                                    </button>
                                    <button v-else class="btn btn-success btn-link btn-block text-center" type="button"
                                        data-toggle="collapse" :data-target="'#collapseOne' + index"
                                        :aria-controls="'collapseOne' + index">
                                        {{
                                            product.type_name_en
                                        }}
                                        <br />
                                        {{

                                            product.type_name_ar
                                        }}
                                    </button>

                                    <input onClick="this.select();" type="number" min="0" step="0.01"
                                        v-model="product.sell_unit.price" :readonly="!user.change_price ||
                                                product.has_Offer
                                                " class="btn" @keyup="calcSum()" />
                                </div>

                                <div class="collapse" :id="'collapseOne' + index" :aria-labelledby="'#headingOne' + index"
                                    data-parent="#accordionExample">
                                    <div class="card-body m-0 p-0 table-responsive">
                                        <table class="text-center w-100 font-weight-bold">
                                            <tbody v-if="cart.length > 0">
                                                <tr :class="product.has_Offer
                                                    ? 'bg-secondary text-light'
                                                    : ''
                                                    ">
                                                    <th>
                                                        {{ __("In Kitchen") }}
                                                    </th>
                                                    <td>
                                                        <input style="width: 30px;height: 30px;" type="checkbox" v-model="product.is_print
                                                            " :id="'for-' + index" />
                                                    </td>
                                                    <th>
                                                        {{ __("Operation") }}
                                                    </th>
                                                    <td>
                                                        <select v-if="product.sell_unit
                                                            " v-model="product.sell_unit
        " class="form-control" @change="
        calcTotalTypeCost(
            product
        )
        ">
                                                            <option
                                                                v-for="(
                                                                                                                                                                 unit, index
                                                                                                                                                            ) in  product.units "
                                                                v-if="unit.unit" :key="index" :selected="unit ===
                                                                    product
                                                                        .sell_unit
                                                                        .unit
                                                                    " :value="unit">
                                                                {{
                                                                    mixins.default_lang ==
                                                                    "en" &&
                                                                    unit.unit
                                                                        .unit_en_name !=
                                                                    "" &&
                                                                    unit.unit
                                                                        .unit_en_name !=
                                                                    null
                                                                    ? unit
                                                                        .unit
                                                                        .unit_en_name
                                                                    : unit
                                                                        .unit
                                                                        .unit_ar_name
                                                                }}
                                                            </option>
                                                        </select>
                                                        <span v-else>-</span>
                                                    </td>

                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>


                                                    <th>
                                                        {{ __("Worker Name") }}
                                                    </th>
                                                    <td>
                                                        <select class="form-control" v-model="product.worker_id
                                                            " @change="calcSum()">
                                                            <option selected value="">
                                                                {{
                                                                    __(
                                                                        "Worker Name"
                                                                    )
                                                                }}
                                                            </option>
                                                            <option
                                                                v-for="(

    worker,
            index

                                                                                                                                                            ) in  workers "
                                                                :key="index" :value="worker.id
                                                                    " class="border-bottom">
                                                                {{
                                                                    worker.name
                                                                }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <th>
                                                        {{ __("Table Number") }}
                                                    </th>
                                                    <td>
                                                        <select v-model="product.chair_id
                                                            " class="form-control">
                                                            <option selected value="">
                                                                {{
                                                                    __(
                                                                        "Choose Table"
                                                                    )
                                                                }}
                                                            </option>
                                                            <option
                                                                v-for="(
                                                                                                                                                                 table, index
                                                                                                                                                            ) in  tables "
                                                                :key="index" :value="table.id
                                                                    " :class="table.is_resrved
        ? 'bg-warning border-bottom'
        : 'border-bottom'
        ">
                                                                {{
                                                                    table.table_no
                                                                }}/
                                                                {{ table.room }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        {{ __("From") }}
                                                    </th>
                                                    <td>
                                                        <date-picker v-model="product.reserve_date
                                                            " id="from" :wrap="true" :config="configs.wrap
        " required :placeholder="__('To')
        ">
                                                        </date-picker>
                                                    </td>
                                                    <th>{{ __("To") }}</th>
                                                    <td>
                                                        <date-picker v-model="product.end_reserve_date
                                                            " id="from" :wrap="true" :config="configs.wrap
        " required :placeholder="__('To')
        ">
                                                        </date-picker>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th v-if="user.type_discount
                                                        ">
                                                        {{
                                                            __("Discount Value")
                                                        }}
                                                    </th>

                                                    <td v-if="user.type_discount
                                                            ">
                                                        <input v-model="product.type_discount_value
                                                            " onClick="this.select();" type="number" min="0"
                                                            step="0.01" class="form-control text-bold" @change="
                                                                onChangeTypeCost(
                                                                    product
                                                                )
                                                                " />
                                                    </td>
                                                    <th>
                                                        {{ __("Total") }}
                                                    </th>
                                                    <td class="text-center">
                                                        {{
                                                            format(
                                                                product.total_type_cost
                                                            )
                                                        }}
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                        <input class="d-block" v-model="product.type_note"
                                            style="
                                                                                                                                        width: 100%;
                                                                                                                                        padding: 0;
                                                                                                                                        border: 0;
                                                                                                                                        box-shadow: none;
                                                                                                                                        text-align: center;
                                                                                                                                    " :placeholder="__('Notes')" />
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                    </div>
                    <!-- End Selected Items-->
                </div>

                <!--Start  All Products -->
                <div class="col-6">
                    <div v-if="!mixins.pretty && !HideMainType" class="col-12">
                        <div id="pills-tab" class="row text-center">
                            <div v-for="( cat, index ) in  filterSearchInCategory " :id="'cat-' + index" :key="index"
                                class=" col-md-3 col-sm-6">
                                <div class="card p-0 text-center" :id="'pills-' + cat.main_type_id + '-tab'" :aria-controls="'pills-' + category.main_type_id
                                    " :class="cat === category
        ? 'nav-link active'
        : 'nav-link bg-warning text-light'
        " :data-bs-target="'#pills-' + cat.main_type_id
        " aria-selected="true" type="button" @click="
        category = cat;
    catName = '';
    HideMainType = true;
    ">
                                    <img loading="lazy" :alt="cat.main_type_title_ar" :src="cat.type_icon != null &&
                                        cat.type_icon != ''
                                        ? cat.type_icon
                                        : 'backend/products/product.png'
                                        " class="w-100" />
                                    <div class="card__shop card-header py-0">
                                        <h2 v-if="mixins.bill_lang == 'ar'" class="card__title w-100 font-weight-bold">
                                            {{
                                                mixins.default_lang == "en" &&
                                                cat.main_type_title_en != "" &&
                                                cat.main_type_title_en != null
                                                ? cat.main_type_title_en
                                                : cat.main_type_title_ar
                                            }}
                                        </h2>
                                        <h2 v-else class="card__title w-100 font-weight-bold">
                                            {{
                                                cat.main_type_title_en
                                            }}
                                            <br />
                                            {{
                                                cat.main_type_title_ar
                                            }}
                                        </h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div :class="mixins.pretty
                            ? 'col-md-9 col-sm-8 px-0'
                            : 'col-md-12 col-sm-12 px-0'
                            " style="border: 1px solid #ddd">
                            <div class="card-header py-0 inbill" v-if="category && HideMainType">
                                <p class="h6 text-center my-0 float-right" v-if="category && HideMainType">
                                    <i v-if="mixins.pretty" class="fa fa-back mx-2" @click="changeView()"></i>
                                    <a v-if="HideMainType && !mixins.pretty" class="btn btn-warning text-light"
                                        @click="HideMainType = false">
                                        <i :class="mixins
                                            .default_lang == 'ar'
                                            ? 'fa fa-arrow-right'
                                            : 'fa fa-arrow-left'
                                            "></i>
                                    </a>
                                    {{ __("Items") }}
                                    {{
                                        mixins.default_lang == "en" &&
                                        category.main_type_title_en != "" &&
                                        category.main_type_title_en != null
                                        ? category.main_type_title_en
                                        : category.main_type_title_ar
                                    }}
                                </p>
                                <input v-if="category && HideMainType" v-model="searchTerm"
                                    class="form-control w-50 float-left" :placeholder="__('Name ar')" type="text" />
                            </div>
                            <div v-if="category && HideMainType" :id="'pills-' + category.main_type_id" :aria-labelledby="'pills-' + category.main_type_id + '-tab'
                                " class="tab-pane fade show" role="tabpanel">
                                <div id="pills-tabContent" class="tab-content">
                                    <div class="row">
                                        <div v-for=" product  in  filterSearchInCatType " :key="product.type_id"
                                            :class="mixins.count_in_row_main" @click="addToCart(product)">
                                            <div class="card text-center mb-2">
                                                <span class="d-none">{{
                                                    product.type_id
                                                }}></span>
                                                <img loading="lazy" :alt="product.type_name_ar" :src="product.type_icon !=
                                                    null &&
                                                    product.type_icon != ''
                                                    ? product.type_icon
                                                    : 'backend/products/product.png'
                                                    " class="w-100" />
                                                <div class="card__shop card-header py-0">
                                                    <b
                                                        class="card__shop__price mt-1 font-weight-bold text-light badge badge-info">{{
                                                            Number(
                                                                product.sell_unit
                                                                    ? product
                                                                        .sell_unit
                                                                        .price
                                                                    : product.type_sill_price
                                                            ).toFixed(
                                                                mixins.digit
                                                            )
                                                        }}</b>
                                                    <h2 class="card__title w-100 font-weight-bold">
                                                        {{
                                                            mixins.default_lang ==
                                                            "en" &&
                                                            product.type_name_en !=
                                                            "" &&
                                                            product.type_name_en !=
                                                            null
                                                            ? product.type_name_en
                                                            : product.type_name_ar
                                                        }}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="mixins.pretty" class="col-md-3 col-sm-4" style="border: 1px solid #ddd">
                            <div class="card-header py-0 inbill">
                                <p class="h6 text-center">
                                    {{ __("Categories") }}
                                </p>
                            </div>
                            <input v-model="catName" class="py-1 w-100" :placeholder="__('Name ar')" type="text" />
                            <ul id="pills-tab" class="nav nav-pills w-100 p-0" role="tablist">
                                <li v-for="(
                                                                                                                                 cat, index
                                                                                                                            ) in  filterSearchInCategory "
                                    :id="'cat-' + index" :key="index" class="cat-0 nav-item my-1 w-100" role="presentation"
                                    style="border: 1px solid #ddd">
                                    <a :id="'pills-' + cat.main_type_id + '-tab'
                                        " :aria-controls="'pills-' + category.main_type_id
        " :class="cat === category
        ? 'nav-link active'
        : 'nav-link'
        " :data-bs-target="'#pills-' + cat.main_type_id
        " aria-selected="true" class="btn btn-outline-primary font-weight-bold text-dark" data-bs-toggle="pill"
                                        role="tab" type="button" @click="
                                            category = cat;
                                        catName = '';
                                        ">
                                        {{
                                            mixins.default_lang == "en" &&
                                            cat.main_type_title_en != "" &&
                                            cat.main_type_title_en != null
                                            ? cat.main_type_title_en
                                            : cat.main_type_title_ar
                                        }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--  End All Products -->
            </div>
            <div id="workerModal" aria-hidden="true" aria-labelledby="workerModalLabel" class="modal fade" role="dialog"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content m-auto" style="min-width: 600px">
                        <div class="modal-header">
                            <h5 id="workerModalLabel" class="modal-title">
                                {{ __("Workers") }}
                            </h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12 mb-4">
                                <div class="table-responsive">
                                    <label><input v-model="form.worker_name" :placeholder="__('Worker Name')"
                                            aria-controls="dataTable" class="py-1 w-100" type="search" /></label>
                                    <table class="table align-items-center">
                                        <thead>
                                            <tr>
                                                <th class="col-header">
                                                    {{ __("Worker Code") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Worker Name") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Mobile") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("commission") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Select") }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(
                                                                                                                                             worker, index
                                                                                                                                        ) in  WorkerFilterSearch "
                                                :key="index">
                                                <td>{{ worker.id }}</td>
                                                <td>
                                                    {{ worker.name }}
                                                </td>
                                                <td>
                                                    {{ worker.mobile }}
                                                </td>
                                                <td>
                                                    {{ worker.commission }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" data-dismiss="modal" @click="
                                                        selectWorker(worker)
                                                        ">
                                                        <i class="fa fa-plus font-weight-bold text-light"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal" type="button">
                                {{ __("Close") }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="exampleModal" aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" role="dialog"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content m-auto" style="min-width: 600px">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">
                                {{ __("Customers") }}
                            </h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12 mb-4">
                                <div class="table-responsive">
                                    <label><input v-model="customer_name" :placeholder="__('Customer Name')"
                                            aria-controls="dataTable" class="py-1 w-100" type="search" /></label>
                                    <table class="table align-items-center">
                                        <thead>
                                            <tr>
                                                <th class="col-header">
                                                    {{ __("Customer Code") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Customer Name") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("mobile") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Balance") }}
                                                </th>
                                                <th class="col-header">
                                                    {{ __("Select") }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(
                                                                                                                                             customer, index
                                                                                                                                        ) in  filterSearch "
                                                :key="index">
                                                <td>{{ customer.cust_id }}</td>
                                                <td>
                                                    {{ customer.cust_name }}
                                                </td>
                                                <td>
                                                    {{ customer.cust_mobile }}
                                                </td>
                                                <td>
                                                    {{ customer.cust_balance }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" data-dismiss="modal" @click="
                                                        selectCustomer(
                                                            customer
                                                        )
                                                        ">
                                                        <i class="fa fa-plus font-weight-bold text-light"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal" type="button">
                                {{ __("Close") }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <Printer :bill="bill" :isSendToKetchen="true" :qr="qr" v-if="mixins.bill_lang == 'ar'" />
                <Printer-ar-en :bill="bill" :isSendToKetchen="true" :qr="qr" v-else />
                <!-- <A4Printer :bill="bill" :qr="qr" v-else /> -->
                <kitchen :bill="tableprint" />
            </div>
        </div>
    </div>
</template>

<script>
import Printer from "../printer";
import PrinterArEn from "../printer_ar_en.vue";
import kitchen from "../kitchen";
import A4Printer from "../A4Printer";
import datePicker from "../date/index";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";

import Spinner from "../spinner/loading.vue";
import { Invoice } from "@axenda/zatca";
import moment, { now } from "moment";
import Tafgeet from "tafgeetjs";
import Calculator from "./Calculator.vue";
import Booking from "../booking.vue";
import BookingArEn from "../booking_ar_en.vue";
export default {
    components: {
        PrinterArEn,
        BookingArEn,
        Printer,
        datePicker,
        Spinner,
        kitchen,
        A4Printer,
        Calculator,
        Booking,
    },
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
        this.mixins.default_lang = localStorage.getItem("lang");
        await this.allMainType();

        await this.allPayMethods();
        await this.allTables();
        await this.allWorkers();
        this.HideMainType = this.mixins.pretty;
        setInterval(async function () {
            if (navigator.onLine) {
                await axios
                    .get("/api/table")
                    .then(({ data }) => (this.tables = data))
                    .catch((error) => console.log(error));
                this.tables.forEach(async (table) => {
                    if (table.end_reserve_date < now()) {

                    }

                    if (
                        moment(moment()).isBetween(
                            table.reserve_date,
                            table.end_reserve_date
                        )
                    ) {
                        table.is_resrved = true;
                        await axios.patch("/api/table/" + table.id, table);
                        // Notification.customMsg(
                        //     "info",
                        //     "topRight",
                        //     "تم حجز الكرسي رقم " + table.table_no
                        // );
                    }
                    if (moment().isAfter(table.end_reserve_date)) {
                        table.is_resrved = false;
                        table.reserve_date = null;
                        table.end_reserve_date = null;
                        await axios.patch("/api/table/" + table.id, table);
                        // Notification.customMsg(
                        //     "info",
                        //     "topRight",
                        //     "  الكرسي رقم " + table.table_no + "متاح"
                        // );
                    }
                    if (table.isNoty) {
                        Notification.customMsg(
                            "info",
                            "topRight",
                            "يرجى حجز الكرسي رقم " + table.table_no
                        );
                    }
                });
            }
        }, 10000);
        if (this.mixins.info_text && this.mixins.info_text != "") {
            this.show_alert = true;
        }
        await this.allBooking();
    },

    computed: {
        filterSearchInCategory() {
            return this.categories.filter((cat) => {
                return cat.main_type_title_ar.match(this.catName);
            });
        },
        filterSearchInCatType() {
            if (this.category.products) {
                return this.category.products.filter((type) => {
                    return type.type_name_ar.match(this.searchTerm);
                });
            }
        },
        filterSearch() {
            return this.customers.filter((customer) => {
                return customer.cust_name.match(this.customer_name);
            });
        },
        WorkerFilterSearch() {
            return this.workers.filter((worker) => {
                return worker.name.match(this.form.worker_name);
            });
        },
    },

    data() {
        return {
            configs: {
                wrap: {
                    allowInputToggle: true,
                },
            },
            calc: false,
            open_table: false,
            user: {},
            show_alert: false,
            disable: false,
            tableprint: {},
            title: "New Bill",
            searchTypes: [],
            showSearchTypeModal: false,
            output: null,
            qr: "",
            isNewbill: true,
            isPrint: false,
            loading: true,
            mixins: {},
            products: [],
            payMethods: [],
            categories: [],
            category: {},
            customers: [],
            customer: {
                cust_name: null,
                cust_address: null,
                cust_mobile: null,
                cust_vat_num: null,
            },
            add_newCutomser: false,
            search: "",
            barcode: "",
            id: "",
            customer_name: "",
            typeName: "",
            isPercentDiscount: true,
            bill_id: 0,
            bill: {},
            cart: [],
            type: {},
            product: {},
            form: {
                retainer: false,
                points: 0,
                pay_from_points: false,
                commission: 0,
                worker_name: "",
                worker_id: "",
                is_included: false,
                current_vat: 0,
                sumAfterDiscount: 0.0,
                user_id: null,
                note: "",
                sum: 0.0,
                discount: 0.0,
                total: 0.0,
                extra: 0.0,
                vat: 0.0,
                cart: [],
                paid: 0.0,
                remain: 0.0,
                customer: {},
                pay: 1,
                isPercentDiscount: true,
                pendingBill: null,
                offerDiscount: 0.0,
                billDiscountPercent: 0.0,
                table: null,
                discountValue: 0.0,
                cash: 0.0,
                card: 0.0,
                isNoty: false,
            },
            salesTypes: [],

            errors: {},
            pending: [],
            selected: "",
            typeUnit: null,
            tables: [],
            catName: "",
            searchTerm: "",
            HideMainType: false,
            weight: 0.0,
            workers: [],
            worker: {},
            bookings: [],
        };
    },

    methods: {
        async create() {
            await axios
                .post("/api/customers", this.customer)
                .then(({ data }) => {
                    this.search = data.cust_mobile;
                    this.findCustomer();
                    Notification.success();
                    this.add_newCutomser = false;
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .then((error) => {
                    if (this.errors.cust_name)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.cust_name[0]
                        );

                    if (this.errors.cust_mobile)
                        Notification.customMsg(
                            "error",
                            "topRight",
                            this.errors.cust_mobile[0]
                        );
                });
        },
        hide() {
            console.log("clicked");

            this.calc = false;
        },
        allSalesType() {
            axios
                .get("/api/saleType")
                .then(({ data }) => {
                    if (data.length >= 0) {
                        this.salesTypes = data;
                    }
                })
                .catch((error) => console.log(error));
        },
        async saveBook(bill) {
            this.clearAll();
            this.cart = [];
            if (bill && bill.table_type && bill.table_type.length > 0) {
                this.form.is_booking = bill.id;
                if (bill.customer != null) {
                    this.customer = bill.customer;
                }
                parseFloat(this.form.vat);
                bill.table_type.forEach(async (product) => {
                    this.product = {};
                    this.product.units = [];
                    if (product.units != null) {
                        this.product.units.push(product.units);

                        this.product.sell_unit = product.sell_unit
                            ? product.sell_unit
                            : "";
                    }
                    this.product.is_print = true;
                    this.product.type_name_ar = product.type.type_name_ar;
                    this.product.sell_unit.price = product.type_price;
                    this.product.type_count = product.type_count;
                    this.product.main_type =
                        product.type.main_type.main_type_id;

                    this.product.type_id = product.type_id;
                    this.product.type_purchases_price =
                        product.type_purchases_price;
                    this.product.total_type_cost = product.type_total_price;
                    this.product.type_note = product.type_note;
                    this.product.type_vat_percent = product.type_vat_percent;
                    this.product.type_sill_price = product.type_price;
                    this.product.type_discount_value = product.type_discount;
                    this.product.type_vat_percent = product.type_vat;
                    this.product.commission = product.commission;
                    this.product.worker_id = product.worker_id;
                    this.product.chair_id = product.chair ? product.chair.id : null;
                    this.product.end_reserve_date = moment(
                        product.end_reserve_date
                    );
                    this.product.reserve_date = moment(product.reserve_date);

                    this.cart.push(this.product);
                });
            }
            this.open_table = false;
            await this.calcSum();
            await this.saveBill();
            this.open_table = false;
        },
        changeView() {
            this.mixins.pretty = !this.mixins.pretty;
        },
        cancel(bill) {
            if (confirm("هل تريد الحذف؟لايمكن الاستعاده مره اخرى.")) {
                axios
                    .delete("api/bills/tables/" + bill.id)
                    .then(() => {
                        this.allBooking();
                        this.clearAll();
                        Notification.successMsg("تم الحذف بنجاح");
                    })
                    .catch(() => {
                        Notification.error();
                    });
            }
        },

        async allMainType() {
            await axios
                .get("/api/AllCategories")
                .then(async ({ data }) => {
                    this.categories = data;
                    this.loading = false;
                    // this.category = this.categories[0];
                })
                .then(() => { })
                .catch((error) => console.log(error));
        },

        async allPayMethods() {
            await axios
                .get("/api/payMethods")
                .then(({ data }) => (this.payMethods = data))
                .catch((error) => console.log(error));
        },
        async allTables() {
            await axios
                .get("/api/table")
                .then(({ data }) => (this.tables = data))
                .catch((error) => console.log(error));
        },
        async allBooking() {
            await axios
                .get("/api/bookings")
                .then(({ data }) => (this.bookings = data))
                .catch((error) => console.log(error));
        },
        async allCustomers() {
            await axios
                .get("/api/action/all/customers")
                .then(({ data }) => (this.customers = data))
                .catch((error) => console.log(error));
        },
        async allWorkers() {
            await axios
                .get("/api/workers")
                .then(({ data }) => (this.workers = data))
                .catch((error) => console.log(error));
        },
        async findCustomer() {
            this.form.discount = 0;
            await axios
                .get("/api/customers/" + this.search)
                .then(async ({ data }) => {
                    this.customer = data;
                    await this.calcSum();
                })
                .catch((error) => console.log(error));
        },
        async findWorker() {
            await axios
                .get("/api/workers/" + this.form.worker_id)
                .then(async ({ data }) => {
                    this.worker = data;
                })
                .catch((error) => console.log(error));
        },
        async findType() {
            await axios
                .get("/api/findTypeByBarcode/" + this.barcode)
                .then(async ({ data }) => {
                    this.type = data;
                    if (this.type.type_id != null) {
                        await this.addToCart(this.type);
                        this.barcode = "";
                    } else {
                        Notification.customMsg(
                            "warning",
                            "topRight",
                            "لايوجد صنف بهذا الاسم"
                        );
                    }
                })
                .catch((error) => console.log(error));
        },
        async findTypeByCodeOrId() {
            await axios
                .get("/api/action/find/" + this.id)
                .then(({ data }) => {
                    this.type = data;
                    if (data.type_id != null) {
                        this.addToCart(data);
                        this.id = "";
                    } else {
                        Notification.customMsg(
                            "warning",
                            "topRight",
                            "لايوجد صنف بهذا الاسم"
                        );
                    }
                })
                .catch((error) => console.log(error));
        },

        async checkIfTypeHasOffer(product) {
            if (product.offers.length > 0) {
                product.offers.map((type) => {
                    if (type.main_type_count === product.type_count) {
                        let offer = type.offer_type;
                        offer.sell_unit.price =
                            offer.sell_unit.price -
                            (offer.sell_unit.price *
                                type.offer_discount_percent) /
                            100.0;

                        offer.type_count = 1;
                        offer.has_Offer = true;
                        this.cart.push(offer);
                        this.calcTotalTypeCost(offer);
                    }
                });
            }
        },

        async findTypeByLike() {
            if (this.typeName != "" && this.typeName != null) {
                await axios
                    .get("/api/action/like/" + this.typeName)
                    .then(({ data }) => {
                        this.searchTypes = data;
                    })
                    .catch((error) => console.log(error));
            }
        },
        async selectCustomer(customer) {
            this.customer = customer;
            this.search = customer.cust_id;
            await this.calcSum();
        },
        async selectWorker(worker) {
            this.worker = worker;
            this.form.worker_id = worker.id;
            await this.calcSum();
        },

        async print(id) {
            await axios
                .get("api/bills/" + id)
                .then(async ({ data }) => {
                    this.bill = data;
                    this.bill.billTotal = 0;
                    if (this.bill.bill_total > 0) {
                        this.bill.billTotal = new Tafgeet(
                            this.bill.bill_total,
                            this.mixins.country == 1 ? "EGP" : "SAR"
                        ).parse();
                    }
                    if (this.bill != null) {
                        const invoice = new Invoice({
                            sellerName: this.mixins.mixins_name,
                            vatRegistrationNumber: this.mixins.contruct_no,
                            invoiceTimestamp: this.bill.bill_date,
                            invoiceTotal: this.bill.bill_total,
                            invoiceVatTotal: this.bill.bill_vat_val,
                        });
                        this.qr = await invoice.render();
                    }
                })
                .then(async () => {
                    $("#printer").click();
                    // $("#btn").click();
                    await $("#distributedir")[0].click();
                })
                .catch((err) => console.log(err));
        },

        async calcIfCustomerHasDiscount() {
            if (
                this.cart.length >= 0 &&
                this.customer &&
                this.form.discount <= 0
            ) {
                if (this.customer.cust_discount_percent > 0) {
                    this.form.discount = 0;

                    this.form.discount = this.customer.cust_discount_percent;
                }
            }
        },
        checkOfferDate() {
            const current = new Date();
            if (
                moment(this.mixins.offer_start_date).isBefore(current) &&
                moment(this.mixins.offer_end_date).isAfter(current)
            ) {
                if (this.mixins.offer_percenet > 0) {
                    this.form.discount = 0;
                    this.form.discount = this.mixins.offer_percenet;
                    this.form.offerDiscount = this.mixins.offer_percenet;
                    return;
                }
            }
        },
        // async addToCart(product) {
        //     // if (this.cart.includes(product)) {
        //     //     product.type_count++;
        //     // } else {
        //     let cloneProduct = await JSON.parse(JSON.stringify(product));
        //     cloneProduct.type_count = 1;
        //     await this.cart.push(cloneProduct);
        //     // this.cart.push(product);
        //     // }
        //     await this.calcTotalTypeCost(cloneProduct);

        //     if (this.mixins.active_type_offer) {
        //         await this.checkIfTypeHasOffer(cloneProduct);
        //     }
        //     this.searchTerm = "";
        // },
        async addToCart(product) {
            this.searchTerm = "";
            this.weight = 0.0;
            if (this.mixins.weight_barcode && product.type_barcode != null) {
                if (product.type_barcode.length === 13) {
                    this.weight =
                        product.type_barcode.substring(7, 12) / 1000.0;
                } else if (product.type_barcode.length === 12) {
                    this.weight =
                        product.type_barcode.substring(6, 11) / 1000.0;
                }
            }

            let cloneProduct = await JSON.parse(JSON.stringify(product));
            cloneProduct.reserve_date = moment();
            cloneProduct.end_reserve_date = moment();
            if (this.weight == 0) {
                cloneProduct.type_count = 1;
                cloneProduct.weight = 1;
            } else {
                cloneProduct.weight = this.weight;
                cloneProduct.type_count += this.weight;
            }
            this.cart.push(cloneProduct);

            await this.calcTotalTypeCost(cloneProduct);
            if (this.mixins.active_type_offer) {
                await this.checkIfTypeHasOffer(cloneProduct);
            }
        },
        async removeFromCart(product, index) {
            product.type_count = 1;
            product.total_type_cost =
                product.type_count * parseFloat(product.sell_unit.price);
            this.$delete(this.cart, index);
            await this.calcSum();
        },
        async increment(product) {
            if (this.mixins.weight_barcode && product.type_barcode != null) {
                if (product.type_barcode.length === 13) {
                    this.weight =
                        product.type_barcode.substring(7, 12) / 1000.0;
                } else if (product.type_barcode.length === 12) {
                    this.weight =
                        product.type_barcode.substring(6, 11) / 1000.0;
                }
            }
            if (this.weight == 0) {
                product.type_count++;
            } else {
                product.type_count += this.weight;
            }
            await this.calcTotalTypeCost(product);
        },
        async decrement(product) {
            if (this.mixins.weight_barcode && product.type_barcode != null) {
                if (product.type_barcode.length === 13) {
                    this.weight =
                        product.type_barcode.substring(7, 12) / 1000.0;
                } else if (product.type_barcode.length === 12) {
                    this.weight =
                        product.type_barcode.substring(6, 11) / 1000.0;
                }
            }
            if (this.weight == 0) {
                if (product.type_count <= 1) {
                    product.type_count = 1;
                } else {
                    product.type_count--;
                }
            } else {
                if (product.type_count <= this.weight) {
                    product.type_count = this.weight;
                } else {
                    product.type_count -= this.weight;
                }
            }
            await this.calcTotalTypeCost(product);
        },
        async onChangeCount(product) {
            if (product.type_count <= 1) {
                product.type_count = 1;
            }
            await this.calcTotalTypeCost(product);
        },
        async onChangeTypeCost(product) {
            // if (product.type_sill_price < product.minimum_sill_price) {
            //     product.type_sill_price = product.minimum_sill_price;
            // }
            await this.calcTotalTypeCost(product);
        },

        async calcTotalTypeCost(product) {
            await this.calcSum();
        },

        async calcSum() {
            this.form.sum = 0;
            this.form.vat = 0;
            this.form.total = 0;
            this.cart.filter(async (product) => {
                if (!product.has_Offer) {
                    product.type_sill_price = product.sell_unit.price ?? 0.0;
                    product.total_type_cost =
                        product.type_count *
                        parseFloat(product.sell_unit.price);
                    product.total_type_cost =
                        product.total_type_cost - product.type_discount_value;
                    this.form.sum =
                        parseFloat(this.form.sum) +
                        parseFloat(product.total_type_cost);
                    await this.calcCommission(product);
                }
            });

            if (this.mixins.mixins_price_include_vat && this.mixins.fixed_vat) {
                let vatVal = this.mixins.mixins_vat_val;
                this.form.sum = this.form.sum / (1 + vatVal / 100.0);
            }

            await this.calcTotal();
        },
        async calcCommission(product) {
            this.form.worker_id = product.worker_id;
            await this.findWorker();
            if (this.worker) {
                if (this.worker.is_percent_commission) {
                    product.commission =
                        product.total_type_cost *
                        (this.worker.commission / 100.0);
                    this.form.worker_id = null;
                    this.worker = null;

                    return;
                }
                product.commission = this.worker.commission;
                this.form.worker_id = null;
                this.worker = null;
            }
        },
        async calcTotal() {
            if (
                this.cart.length === 0 &&
                this.form.discount > this.form.total
            ) {
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن ان يكون الخصم اكبر من الاجمالي",
                    5000
                );
                this.form.discount = 0;
            }
            this.form.total = 0;

            await this.calcIfCustomerHasDiscount();
            if (this.mixins.active_offer) {
                await this.checkOfferDate();
            }

            this.form.total =
                parseFloat(this.form.sum) + parseFloat(this.form.extra);

            if (
                this.form.table != null &&
                this.form.table.mini_charge > 0 &&
                this.form.sum < this.form.table.mini_charge
            ) {
                this.form.total =
                    Number(this.form.total) +
                    Number(this.form.table.mini_charge);
            }
            this.form.offerDiscount =
                (parseFloat(this.form.total) *
                    parseFloat(this.form.offerDiscount)) /
                100.0;
            this.form.billDiscountPercent =
                (parseFloat(this.form.total) * parseFloat(this.form.discount)) /
                100.0;
            this.form.total =
                parseFloat(this.form.total) -
                parseFloat(this.form.billDiscountPercent);

            this.form.sumAfterDiscount = this.form.total;

            await this.calcVat(this.form.total);
            this.form.total =
                parseFloat(this.form.total) + parseFloat(this.form.vat);

            this.form.vat = this.format(this.form.vat);
            this.form.sum = this.format(this.form.sum);
            this.form.sumAfterDiscount = this.format(
                this.form.sumAfterDiscount
            );

            if (this.mixins.smoken_vat) {
                this.form.total = this.form.total * 2;
            }
            this.form.total = this.format(this.form.total);
            this.form.discount = this.format(this.form.discount);
            if (this.form.pay !== 3) {
                this.form.paid = this.form.total;
                this.form.remain = 0;
            } else if (this.form.pay == 4) {
                this.form.card = this.form.total;
                this.form.cash = 0;
            } else {
                this.form.remain = this.form.total;
                this.form.paid = 0;
            }
            this.form.paid = this.format(this.form.paid);
            this.form.cash = this.format(this.form.cash);
            this.form.remain = this.format(this.form.remain);
            this.form.card = this.format(this.form.card);
        },
        async calcVat(total) {
            this.form.vat = 0;
            if (!this.mixins.fixed_vat) {
                this.cart.filter((product) => {
                    this.form.vat =
                        parseFloat(this.form.vat) +
                        (product.total_type_cost * product.type_vat_percent) /
                        100.0;
                });
                return;
            }
            if (this.mixins.mixins_vat_val > 0 && this.mixins.fixed_vat) {
                let vatVal = this.mixins.mixins_vat_val;
                this.form.vat = (total * vatVal) / 100.0;
                return;
            }
        },
        calcRemain() {
            this.form.remain = this.form.total - this.form.paid;
            this.form.remain = parseFloat(this.form.remain);
        },
        async calcPaidCash() {
            this.form.card = this.form.total - this.form.cash;
            this.form.cash = parseFloat(this.form.cash);
            await this.retainerFunc();

        },
        format(num) {
            return parseFloat(num).toFixed(this.mixins.digit);
        },
        async saveBill() {
            // await this.calcSum();
            let isValid = true;
            this.cart.filter(async (product) => {
                if (!product.worker_id || product.worker_id == null) {
                    isValid = false;
                    Notification.customMsg(
                        "error",
                        "topRight",
                        "يجب اختيار الموظف"
                    );
                    return;
                }
                if (!product.reserve_date || product.reserve_date == null) {
                    isValid = false;
                    Notification.customMsg(
                        "error",
                        "topRight",
                        "يجب تحديد موعد الحجز"
                    );
                    return;
                }
                if (
                    !product.end_reserve_date ||
                    product.end_reserve_date == null
                ) {
                    isValid = false;
                    Notification.customMsg(
                        "error",
                        "topRight",
                        "يجب تحديد انتهاء الحجز"
                    );
                    return;
                }
                // if (!product.chair_id || product.chair_id == null) {
                //     isValid = false;
                //     Notification.customMsg(
                //         "error",
                //         "topRight",
                //         "يجب اختيار الكرسي"
                //     );
                //     return;
                // }
            });
            if (this.cart.length <= 0) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن حفظ فاتورة بدون أصناف"
                );
                return;
            }
            if (this.form.total <= 0 && this.form.discount <= 0) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن حفظ فاتورة قيمتها صفر"
                );
                return;
            }
            if (
                (this.form.pay == 1 || this.form.pay == 2) &&
                this.form.paid < this.form.total
            ) {
                isValid = false;

                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن دفع مبلغ أقل من الاجمالي، يجب دفع قيمة مساوبة للاجمالي أو أكبر منها أو إختيار طريقة دفع أجل مع تحديد عميل",
                    5000
                );
                return;
            }
            if (this.form.retainer) {
                isValid = false;

                Notification.customMsg(
                    "error",
                    "topRight",
                    "يرجى التاكد من المبالغ المدفوعة",
                    5000
                );
                return;
            }
            if (this.form.pay == 3 && this.customer.cust_id == null) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "الفاتورة آجل! يجب اختيار عميل",
                    5000
                );
                return;
            }
            if (this.form.pay_from_points) {
                let total = this.customer.points * this.mixins.point_price;
                // 16000
                if (total < this.form.total) {
                    Notification.customMsg(
                        "error",
                        "topRight",
                        "إجمالي النقاط أقل من الفاتورة !"
                    );
                    isValid = false;
                    return;

                }
                let remain = total - this.form.total; //40
                this.form.points = remain / this.mixins.point_every * 10

            }
            if (isValid) await this.saveValidBill();

        },
        async saveValidBill() {
            console.error(this.form.points)

            this.form.user_id = localStorage.getItem("user_id");
            this.form.cart = this.cart;
            this.form.customer = this.customer;
            this.form.is_included = this.mixins.mixins_price_include_vat;
            this.form.current_vat = this.mixins.mixins_vat_val;

            if (this.form.cart.length > 0) {
                this.disable = true;
                await axios
                    .post("api/bills", this.form)
                    .then(async (data) => {
                        this.disable = false;
                        Notification.success();
                        if (this.form.is_booking) {
                            this.allBooking();
                        }
                        this.clearAll();
                        this.allTables();
                        this.print(data.data);
                        this.isPrint = true;
                    })
                    .catch((error) => {
                        if (!error.response) {
                            this.disable = false;
                            Notification.customMsg(
                                "error",
                                "topRight",
                                "تأكد من اتصالك بالانترنت او اتصالك بالانترنت ضعيف",
                                5000
                            );
                        }
                        this.disable = false;
                    });
                if (this.mixins.closure_hour != null) {
                    let currentDate = moment().format("yyyy-MM-DD");
                    let timerDate = moment(
                        localStorage.getItem("timerDate")
                    ).format("yyyy-MM-DD");
                    if (!timerDate) {
                        localStorage.setItem("orderNum", 1);
                        localStorage.setItem(
                            "timerDate",
                            moment().format("yyyy-MM-DD")
                        );
                    }
                    if (
                        !moment(timerDate).isSame(currentDate) &&
                        moment().hours() > 4
                    ) {
                        localStorage.setItem(
                            "timerDate",
                            moment().format("yyyy-MM-DD")
                        );
                        localStorage.setItem("orderNum", 1);
                    } else {
                        localStorage.setItem(
                            "orderNum",
                            Number(localStorage.getItem("orderNum")) + 1
                        );
                        localStorage.setItem(
                            "timerDate",
                            moment().format("yyyy-MM-DD")
                        );
                    }

                    // $("#btn").click();
                }
            } else {
                Notification.error();
                this.disable = false;
            }
        },
        async saveToTable(isNoty) {
            if (this.form.pay == 4) {

                await this.retainerFunc();
            }
            let isValid = true;
            if (this.cart.length > 0) {
                this.cart.filter(async (product) => {
                    if (!product.worker_id || product.worker_id == null) {
                        isValid = false;
                        Notification.customMsg(
                            "error",
                            "topRight",
                            "يجب اختيار الموظف"
                        );
                        return;
                    }
                    if (!product.reserve_date || product.reserve_date == null) {
                        isValid = false;
                        Notification.customMsg(
                            "error",
                            "topRight",
                            "يجب تحديد موعد الحجز"
                        );
                        return;
                    }
                    if (
                        !product.end_reserve_date ||
                        product.end_reserve_date == null
                    ) {
                        isValid = false;
                        Notification.customMsg(
                            "error",
                            "topRight",
                            "يجب تحديد انتهاء الحجز"
                        );
                        return;
                    }
                    // if (!product.chair_id || product.chair_id == null) {
                    //     isValid = false;
                    //     Notification.customMsg(
                    //         "error",
                    //         "topRight",
                    //         "يجب اختيار الكرسي"
                    //     );
                    //     return;
                    // }
                });
                if (isValid) {
                    await this.saveValidToTable(isNoty);
                }
            }
        },
        async saveValidToTable(isNoty) {
            this.disable = true;
            this.form.user_id = this.user.id;
            this.form.cart = this.cart;
            this.form.isNoty = isNoty;
            this.form.customer = this.customer;
            await axios
                .post("api/bills/tables", this.form)
                .then(async (res) => {
                    this.tableprint = await res.data;
                });
            $("#distribute")[0].click();
            this.disable = false;
            Notification.success();
            // setTimeout(() => $("#kitchenBtn").click(), 500);
            await this.allBooking();

            this.clearAll();
        },

        async editBook(bill) {
            this.clearAll();
            this.cart = [];
            if (bill && bill.table_type && bill.table_type.length > 0) {
                if (bill.customer != null) {
                    this.customer = bill.customer;
                }
                this.form.is_booking = bill.id;
                parseFloat(this.form.vat);
                bill.table_type.forEach(async (product) => {
                    this.product = {};
                    this.product.units = [];
                    if (product.units != null) {
                        this.product.units.push(product.units);
                        this.product.sell_unit = product.sell_unit
                            ? product.sell_unit
                            : "";
                    } else {
                        this.product.sell_unit = null;
                    }
                    this.product.is_print = true;
                    this.product.type_name_ar = product.type.type_name_ar;
                    this.product.sell_unit.price = product.type_price;
                    this.product.type_purchases_price =
                        product.type_purchases_price;
                    this.product.main_type =
                        product.type.main_type.main_type_id;
                    this.product.type_count = product.type_count;
                    this.product.type_sill_price = product.type_price;
                    this.product.type_id = product.type_id;
                    this.product.total_type_cost = product.type_total_price;
                    this.product.type_note = product.type_note;
                    this.product.type_vat_percent = product.type_vat_percent;
                    this.product.type_discount_value = product.type_discount;
                    this.product.type_vat_percent = product.type_vat;
                    this.product.commission = product.commission;
                    this.product.worker_id = product.worker_id;
                    this.product.chair_id = product.chair ? product.chair.id : null;
                    this.product.end_reserve_date = moment(
                        product.end_reserve_date
                    );
                    this.product.reserve_date = moment(product.reserve_date);
                    this.cart.push(this.product);
                });
                this.open_table = false;

                await this.calcSum();
                if (bill.bill_paid_type == 4) {
                    this.form.pay = bill.bill_paid_type;
                    this.form.retainer = true
                    this.form.card = bill.card;
                    this.form.cash = bill.cash;
                    await this.retainerFunc();
                }
            }
        },
        retainerFunc() {
            if (this.form.retainer) {
                this.form.paid = parseInt(this.form.card) + parseInt(this.form.cash);
            }
            this.calcRemain();
        },

        clearAll() {
            this.form.retainer = false;
            this.form.is_booking = null;
            this.form.commission = 0;
            this.form.worker_name = "";
            this.form.worker_id = "";
            this.form.vat = 0.0;
            this.customer = {};
            this.worker = {};
            this.search = "";
            this.bill = {};
            this.disabled = false;
            this.isPrint = false;
            this.cart = [];
            this.pay_from_points = false;
            this.points = 0;
            this.form = {
                pay_from_points: false,
                points: 0,
                sumAfterDiscount: 0.0,
                user_id: null,
                note: "",
                sum: 0.0,
                discount: 0.0,
                total: 0.0,
                extra: 0.0,
                vat: 0.0,
                cart: [],
                paid: 0.0,
                remain: 0.0,
                customer: {},
                pay: 1,
                isPercentDiscount: true,
                offerDiscount: 0.0,
                billDiscountPercent: 0.0,
                card: 0.0,
                cash: 0.0,
                isNoty: false,

            };
            this.barcode = ""
        },
    },
};
</script>
<style scoped>
.card__shop__price {
    position: absolute;
    bottom: 100%;
    right: 0;
}

.card__shop.card-header {
    padding: 0 0 !important;
}

b.btn {
    float: right;
}

.fa {
    cursor: pointer;
}

body {
    /*background: var(--secondary);*/
    transition: background 0.3s;
    gap: 20px;
    font-family: "Poppins", sans-serif;
}

.tab-content .card {
    cursor: pointer;
}

option {
    border-bottom: 1px solid #ddd;
}

option:hover {
    color: #000;
    background: #fff;
}

.newBill .card-header {
    border-radius: 0;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    font-weight: bolder;
}

.tab-content .card:hover,
.selected .card .card:hover {
    transform: scale(1.09);
}

.newBill .card img {
    width: 160px;
    height: 100px;
    max-height: 100px;
    object-fit: cover;
}

.newBill .card__title {
    margin-top: 5px;
    font-size: 15px;
    font-weight: 400;
    transition: color 0.3s;
}

.newBill .card__shop {
    width: 100%;
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.newBill .card__shop__action span {
    color: #fff;
    font-size: 26px;
}

.newBill .card {
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;

}

.frame {
    border: 1px solid #ccc;
    box-shadow: 0 0 3px 2x rgba(0, 0, 0, 0.3);
    margin: 20px auto;
    height: 200px;
    width: 95%;
}
</style>
