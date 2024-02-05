<template>
    <div
        v-if="!loading"
        :class="mixins.default_lang"
        id="navbar"
        v-show="user || ($route.path == '/' ? false : true)"
    >
        <!-- Navbar -->

        <nav
            v-show="mixins && $route.path === '/' ? false : true"
            style="display: none"
            class="main-header navbar navbar-expand navbar-white navbar-light py-0"
        >
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li v-if="mixins.show_side_menu" class="nav-item">
                    <router-link
                        class="nav-link"
                        data-widget="pushmenu"
                        to="#"
                        role="button"
                        ><i class="fas fa-bars"></i
                    ></router-link>
                </li>
                <li class="nav-item">
                    <router-link
                        to="/home"
                        :class="
                            $route.path === '/home'
                                ? 'nav-link  active'
                                : 'nav-link '
                        "
                    >
                        {{ __("Home") }}</router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link
                        to="/bill"
                        :class="
                            $route.path === '/bill'
                                ? 'nav-link  active'
                                : 'nav-link '
                        "
                    >
                        {{ __("New Bill") }}</router-link
                    >
                </li>
                <li class="nav-item d-none d-lg-inline-block">
                    <router-link
                        to="/bills"
                        :class="
                            $route.path === '/bills'
                                ? 'nav-link  active'
                                : 'nav-link '
                        "
                    >
                        {{ __("Bills") }}
                    </router-link>
                </li>
                <li class="nav-item d-none d-lg-inline-block">
                    <router-link
                        to="/process"
                        :class="
                            $route.path === '/return'
                                ? 'nav-link  active'
                                : 'nav-link '
                        "
                    >
                        <p>{{ __("Manage Exit bill") }}</p>
                    </router-link>
                </li>
                <li class="nav-item dropdown top-dbdn d-none d-lg-inline-block">
                    <router-link
                        class="nav-link dropdown-toggle"
                        to="#"
                        role="button"
                        id="dropdownMenuLink"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        {{ __("Reports") }}
                    </router-link>

                    <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuLink"
                    >
                        <router-link
                            to="/bills/report/daily"
                            :class="
                                $route.path === '/bills/report/daily'
                                    ? 'dropdown-item  active'
                                    : 'dropdown-item '
                            "
                        >
                            <p>{{ __("Today Report") }}</p>
                        </router-link>

                        <router-link
                            to="/bills/report/monthly"
                            :class="
                                $route.path === '/bills/report/monthly'
                                    ? 'dropdown-item  active'
                                    : 'dropdown-item '
                            "
                        >
                            <p>{{ __("Monthly Report") }}</p>
                        </router-link>

                        <router-link
                            to="/bills/report"
                            :class="
                                $route.path === '/bills/report'
                                    ? 'dropdown-item  active'
                                    : 'dropdown-item '
                            "
                        >
                            <p>{{ __("Period Report") }}</p>
                        </router-link>

                        <router-link
                            to="/Fbills"
                            :class="
                                $route.path === '/Fbills'
                                    ? 'dropdown-item  active d-none'
                                    : 'dropdown-item d-none'
                            "
                        >
                            <p>{{ __("Bills Report") }}</p>
                        </router-link>

                        <router-link
                            to="/RTypes"
                            :class="
                                $route.path === '/RTypes'
                                    ? 'dropdown-item  active d-none'
                                    : 'dropdown-item d-none'
                            "
                        >
                            <p>{{ __("Types Report") }}</p>
                        </router-link>

                        <router-link
                            to="/ProcessReport"
                            :class="
                                $route.path === '/ProcessReport'
                                    ? 'dropdown-item  active'
                                    : 'dropdown-item '
                            "
                        >
                            <p>{{ __("Process Bills Report") }}</p>
                        </router-link>

                        <router-link
                            to="/customers/report"
                            :class="
                                $route.path === '/customers/report'
                                    ? 'dropdown-item  active'
                                    : 'dropdown-item '
                            "
                        >
                            <p>{{ __("Customers Report") }}</p>
                        </router-link>

                        <router-link
                            to="/search"
                            :class="
                                $route.path === '/search'
                                    ? 'dropdown-item  active'
                                    : 'dropdown-item '
                            "
                        >
                            <p>{{ __("Search Report") }}</p>
                        </router-link>

                        <router-link
                            to="/shiftReport"
                            :class="
                                $route.path === '/shiftReport'
                                    ? 'dropdown-item  active'
                                    : 'dropdown-item '
                            "
                        >
                            <p>{{ __("Shift Report") }}</p>
                        </router-link>

                        <router-link
                            to="/attendance/report"
                            :class="
                                $route.path === '/attendance/report'
                                    ? 'dropdown-item  active  d-none'
                                    : 'dropdown-item  d-none'
                            "
                        >
                            <p>{{ __("Attendance And Leave report") }}</p>
                        </router-link>
                    </div>
                </li>
                <li class="nav-item d-none">
                    <router-link
                        to="/attendance"
                        :class="
                            $route.path === '/attendance'
                                ? 'nav-link  active'
                                : 'nav-link '
                        "
                    >
                        <p>
                            {{ __("Attendance And Leave") }}
                        </p>
                    </router-link>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item d-none d-lg-inline-block">
                    <router-link
                        to="/mixins"
                        :class="
                            $route.path === '/mixins'
                                ? 'nav-link  active'
                                : 'nav-link '
                        "
                    >
                        <i class="nav-icon fas fa-cog"></i>
                    </router-link>
                </li>
                <li class="nav-item dropdown top-dbdn d-none d-lg-inline-block">
                    <router-link
                        class="nav-link dropdown-toggle"
                        to="#"
                        role="button"
                        id="dropdownMenuLink"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        {{ mixins.default_lang }}
                    </router-link>
                    <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuLink"
                    >
                        <a
                            role="button"
                            @click.prevent="changeLang('ar')"
                            class="nav-link"
                            href="#"
                        >
                            <p>ar</p>
                        </a>
                        <a
                            role="button"
                            @click.prevent="changeLang('en')"
                            class="nav-link"
                            href="#"
                        >
                            <p>En</p>
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown top-dbdn d-none d-lg-inline-block">
                    <router-link
                        class="nav-link dropdown-toggle"
                        to="#"
                        role="button"
                        id="dropdownMenuLink"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        {{ __("Help") }}
                    </router-link>

                    <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuLink"
                    >
                        <router-link
                            class="nav-link"
                            to="/update"
                            role="button"
                        >
                            تحديث
                        </router-link>
                    </div>
                </li>

                <li class="nav-item d-none d-lg-inline-block">
                    <a onClick="go_full_screen();" class="nav-link">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <router-link
                        :class="
                            $route.path === '/logout'
                                ? 'nav-link  active'
                                : 'nav-link '
                        "
                        to="/logout"
                    >
                        <i class="fas fa-sign-out-alt"></i>
                    </router-link>
                </li>
                <li class="nav-item d-none">
                    <router-link
                        class="nav-link"
                        data-widget="control-sidebar"
                        data-slide="true"
                        to="#"
                        role="button"
                    >
                        <i class="fas fa-th-large"></i>
                    </router-link>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside
            v-if="mixins.show_side_menu"
            class="main-sidebar sidebar-light-olive elevation-4"
            style="display: none"
            v-show="$route.path === '/' ? false : true"
        >
            <!-- Brand Logo -->
            <router-link to="/mixins" class="brand-link">
                <img
                    :src="mixins.mixins_logo"
                    alt="Gusto"
                    class="brand-image img-circle"
                />
                <span class="brand-text font-weight-light">
                    {{ mixins.mixins_name }}</span
                >
            </router-link>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex d-none">
                    <div class="image">
                        <img
                            src="backend/img/menu/users (1).png"
                            class="img-circle elevation-2"
                            alt="User Image"
                        />
                    </div>
                    <div class="info">
                        <router-link to="/bill" class="d-block userName">{{
                            user.name
                        }}</router-link>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input
                            class="form-control form-control-sidebar"
                            type="search"
                            placeholder="Search"
                            aria-label="Search"
                        />
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul
                        class="nav nav-pills nav-sidebar flex-column"
                        data-widget="treeview"
                        role="menu"
                        data-accordion="false"
                    >
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <router-link
                                :class="
                                    $route.path === '/bill'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                                to="/bill"
                            >
                                <i class="nav-icon fa fa-dashboard"></i>
                                <p>
                                    {{ __("New Bill") }}
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link
                                :class="
                                    $route.path === '/sales'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                                to="/sales"
                            >
                                <i class="nav-icon fa fa-tachometer"></i>
                                <p>
                                    {{ __("Sales Types") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <a href="#" role="button" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    {{ __("Bills") }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link
                                        to="/bills"
                                        :class="
                                            $route.path === '/bills'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa  fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Bills") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/process"
                                        :class="
                                            $route.path === '/return'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Manage Exit bill") }}</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <router-link to="#" class="nav-link">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    {{ __("Types") }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </router-link>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link
                                        to="/mainTypes"
                                        :class="
                                            $route.path === '/mainTypes'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Categories") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/units"
                                        :class="
                                            $route.path === '/units'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Operation") }}</p>
                                    </router-link>
                                </li>

                                <li class="nav-item">
                                    <router-link
                                        to="/types"
                                        id="types"
                                        :class="
                                            $route.path === '/types'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Types") }}</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <router-link to="#" class="nav-link">
                                <i class="nav-icon fa fa-bar-chart"></i>
                                <p>
                                    {{ __("Reports") }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </router-link>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link
                                        to="/bills/report/daily"
                                        :class="
                                            $route.path ===
                                            '/bills/report/daily'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Today Report") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/bills/report/monthly"
                                        :class="
                                            $route.path ===
                                            '/bills/report/monthly'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Monthly Report") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/bills/report"
                                        :class="
                                            $route.path === '/bills/report'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Period Report") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/Fbills"
                                        :class="
                                            $route.path === '/Fbills'
                                                ? 'nav-link  active d-none'
                                                : 'nav-link d-none'
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Bills Report") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/RTypes"
                                        :class="
                                            $route.path === '/RTypes'
                                                ? 'nav-link  active d-none'
                                                : 'nav-link d-none'
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Types Report") }}</p>
                                    </router-link>
                                </li>
                                <li
                                    v-if="mixins.country == '2'"
                                    class="nav-item"
                                >
                                    <router-link
                                        to="/ProcessReport"
                                        :class="
                                            $route.path === '/ProcessReport'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Process Bills Report") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/customers/report"
                                        :class="
                                            $route.path === '/customers/report'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Customers Report") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        to="/search"
                                        :class="
                                            $route.path === '/search'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Search Report") }}</p>
                                    </router-link>
                                </li>

                                <li class="nav-item">
                                    <router-link
                                        to="/shiftReport"
                                        :class="
                                            $route.path === '/shiftReport'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>{{ __("Shift Report") }}</p>
                                    </router-link>
                                </li>
                                <li class="nav-item d-none">
                                    <router-link
                                        to="/attendance/report"
                                        :class="
                                            $route.path === '/attendance/report'
                                                ? 'nav-link  active'
                                                : 'nav-link '
                                        "
                                    >
                                        <i class="fa fa-arrow-left nav-icon"></i>
                                        <p>
                                            {{
                                                __(
                                                    "Attendance And Leave report"
                                                )
                                            }}
                                        </p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <router-link
                                to="/offers"
                                :class="
                                    $route.path === '/offers'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-gift"></i>
                                <p>
                                    {{ __("Offers") }}
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link
                                to="/stocks"
                                :class="
                                    $route.path === '/stocks'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fa fa-database"></i>
                                <p>
                                    {{ __("Manage Stock") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/gusto/stocks"
                                :class="
                                    $route.path === '/gusto/stocks'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>
                                    {{ __("Create Order") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/shift"
                                :class="
                                    $route.path === '/shift'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-money-check"></i>
                                <p>
                                    {{ __("shifts") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/cash"
                                :class="
                                    $route.path === '/cash'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-money-check"></i>
                                <p>
                                    {{ __("Cash") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/suppliers"
                                :class="
                                    $route.path === '/suppliers'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fa fa-truck"></i>
                                <p>
                                    {{ __("Suppliers") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/expenses"
                                :class="
                                    $route.path === '/expenses'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas  fa-minus-circle"></i>
                                <p>
                                    {{ __("Expenses") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/customers"
                                :class="
                                    $route.path === '/customers'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    {{ __("Customers") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/workers"
                                :class="
                                    $route.path === '/workers'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    {{ __("Workers") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/users"
                                :class="
                                    $route.path === '/users'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    {{ __("Users") }}
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item d-none">
                            <router-link
                                to="/barcode"
                                :class="
                                    $route.path === '/barcode'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-barcode"></i>
                                <p>
                                    {{ __("Barcode Settings") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item d-none">
                            <router-link
                                to="/attendance"
                                :class="
                                    $route.path === '/attendance'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-clock"></i>
                                <p>
                                    {{ __("Attendance And Leave") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/mixins"
                                :class="
                                    $route.path === '/mixins'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    {{ __("Settings") }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                to="/typesToExcel"
                                :class="
                                    $route.path === '/typesToExcel'
                                        ? 'nav-link  active'
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-print"></i>
                                <p>
                                    {{ __("Print") }}
                                </p>
                            </router-link>
                        </li>
                        <li
                            v-if="mixins.country == '1'"
                            class="nav-item bg-danger border-1"
                        >
                            <router-link
                                to="/trash"
                                :class="
                                    $route.path === '/trash'
                                        ? 'nav-link  active '
                                        : 'nav-link '
                                "
                            >
                                <i class="nav-icon fas fa-trash"></i>
                                <p>
                                    {{ __("Trash") }}
                                </p>
                            </router-link>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
    </div>
</template>

<script>

export default {
    name: "sidebar",
    async created() {
        this.user = await Auth.getAuth();
        this.mixins = this.user.branch;
    },

    data() {
        return {
            mixins: {},
            loading: false,
            title: "Loading",
            user: {},
        };
    },
    methods: {
        async changeLang(lang) {
            this.mixins.default_lang = lang;
            await axios.patch(
                "/api/mixins/" + this.user.branch_id,
                this.mixins
            );
            localStorage.setItem("lang", lang);
            await location.reload(true);
        },
    },
};
</script>
