<!-- Navbar -->

<nav v-if="$root.$data.codies" v-show="$route.path==='/'?false:true" style="display: none"
    class="main-header navbar navbar-expand navbar-white navbar-light py-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item" v-if="$root.$data.codies.show_side_menu">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none" >

            <a class="nav-link" href="{{ route('testPrint') }}" role="button">
                test
            </a>
        </li>
        <li class="nav-item ">
            <router-link to="/home"
                :class="$route.path === '/home' ?
                    'nav-link  active' :
                    'nav-link '">
                {{ trans('lang.Home') }}</router-link>
        </li>
        <li class="nav-item ">
            <router-link to="/bill"
                :class="$route.path === '/bill' ?
                    'nav-link  active' :
                    'nav-link '">
                {{ trans('lang.New Bill') }}</router-link>
        </li>

        <li class="nav-item d-none d-lg-inline-block">
            <router-link to="/bills"
                :class="$route.path === '/bills' ?
                    'nav-link  active' :
                    'nav-link '">
                {{ trans('lang.Bills') }}
            </router-link>
        </li>

        <li class="nav-item d-none d-lg-inline-block">
            <router-link to="/process"
                :class="$route.path === '/return' ?
                    'nav-link  active' :
                    'nav-link '">
                <p>{{ trans('lang.Manage Exit bill') }}</p>
            </router-link>
        </li>

        <li class="nav-item d-none d-lg-inline-block">
            <router-link to="/shift"
                :class="$route.path === '/shift' ?
                    'nav-link  active' :
                    'nav-link '">
                <p>
                    {{ trans('lang.shifts') }}
                </p>
            </router-link>

        </li>


        {{-- <li class="nav-item dropdown top-dbdn d-none d-lg-inline-block  d-none"> --}}

        <li class="nav-item  d-none">
            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ trans('lang.Reports') }}
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                <router-link to="/bills/report/daily"
                    :class="$route.path === '/bills/report/daily' ?
                        'dropdown-item  active' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Today Report') }}</p>
                </router-link>


                <router-link to="/bills/report/monthly"
                    :class="$route.path === '/bills/report/monthly' ?
                        'dropdown-item  active' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Monthly Report') }}</p>
                </router-link>


                <router-link to="/bills/report"
                    :class="$route.path === '/bills/report' ?
                        'dropdown-item  active' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Period Report') }}</p>
                </router-link>


                <router-link to="/appreport"
                    :class="$route.path === '/appreport' ?
                        'dropdown-item  active' :
                        'dropdown-item'">

                    <p>{{ trans('lang.Bills Report') }}</p>
                </router-link>


                <router-link to="/TypeReport "
                    :class="$route.path === '/TypeReport' ?
                        'dropdown-item  active ' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Types Report') }}</p>
                </router-link>

                <router-link to="/workerReport "
                    :class="$route.path === '/workerReport' ?
                        'dropdown-item  active ' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Workers Report') }}</p>
                </router-link>

                <router-link v-if="$root.$data.codies.country == 2" to="/ProcessReport"
                    :class="$route.path === '/ProcessReport' ?
                        'dropdown-item  active' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Process Bills Report') }}</p>
                </router-link>

                <router-link to="/customers/report"
                    :class="$route.path === '/customers/report' ?
                        'dropdown-item  active' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Customers Report') }}</p>
                </router-link>


                <router-link to="/search"
                    :class="$route.path === '/search' ?
                        'dropdown-item  active' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Search Report') }}</p>
                </router-link>





                <router-link to="/shiftReport"
                    :class="$route.path === '/shiftReport' ?
                        'dropdown-item  active' :
                        'dropdown-item '">

                    <p>{{ trans('lang.Shift Report') }}</p>
                </router-link>

                <router-link to="/attendance/report"
                    :class="$route.path === '/attendance/report' ?
                        'dropdown-item  active  d-none' :
                        'dropdown-item  d-none'">

                    <p>{{ trans('lang.Attendance And Leave report') }}</p>
                </router-link>



            </div>
        </li>
        <li class="nav-item d-none ">
            <router-link to="/attendance"
                :class="$route.path === '/attendance' ?
                    'nav-link  active' :
                    'nav-link '">
                <p>
                    {{ trans('lang.Attendance And Leave') }}
                </p>
            </router-link>

        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto ">
        <!-- Navbar Search -->
        <li class="nav-item d-none d-lg-inline-block">
            <router-link to="/mixins"
                :class="$route.path === '/mixins' ?
                    'nav-link  active' :
                    'nav-link '">
                <i class="nav-icon fas fa-cog"></i>

            </router-link>

        </li>
        <li class="nav-item dropdown top-dbdn d-none d-lg-inline-block">
            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ App::getLocale() }}
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @foreach (config('lang.available_languages') as $langLocale => $langName)
                    <a role="button" class="nav-link" href="?lang={{ $langLocale }}">
                        <p>
                            {{ strtoupper($langLocale) }}

                        </p>
                    </a>
                @endforeach
            </div>
        </li>
        {{-- <li class="nav-item dropdown top-dbdn d-none d-lg-inline-block"> --}}

        <li class="nav-item d-none">
            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ trans('lang.Help') }}
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="nav-link" href="{{ route('update') }}" role="button">
                    تحديث
                </a>
            </div>
        </li>

        <li class="nav-item d-none d-lg-inline-block">
            <a onClick="go_full_screen();" class="nav-link">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <router-link
                :class="$route.path === '/logout' ?
                    'nav-link  active' :
                    'nav-link '"
                to="/logout">
                <i class="fas fa-sign-out-alt"></i>
            </router-link>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>


    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside v-if="$root.$data.codies&&$root.$data.codies.show_side_menu" class="main-sidebar sidebar-light-olive elevation-4"
    style="display: none" v-show="$route.path==='/'?false:true">
    <!-- Brand Logo -->
    <router-link to="/mixins" class="brand-link">
        <img src="{{ asset($codies->mixins_logo) }}" alt="Gusto" class="brand-image img-circle">
        <span class="brand-text font-weight-light" v-html="$root.$data.codies.mixins_name"></span>
    </router-link>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex d-none">
            <div class="image">
                <img src="{{ asset('backend/img/menu/users (1).png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">

                <router-link to="/bill" class="d-block" v-html="$root.$data.user.name">
                </router-link>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline d-none">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <router-link
                        :class="$route.path === '/bill' ?
                            'nav-link  active' :
                            'nav-link '"
                        to="/bill">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ trans('lang.New Bill') }}

                        </p>
                    </router-link>
                </li>

                <li class="nav-item d-none">
                    <router-link
                        :class="$route.path === '/sales' ?
                            'nav-link  active' :
                            'nav-link '"
                        to="/sales">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ trans('lang.Sales Types') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item menu-open">
                    <router-link to="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{ trans('lang.Bills') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </router-link>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/bills"
                                :class="$route.path === '/bills' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Bills') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/process"
                                :class="$route.path === '/return' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Manage Exit bill') }}</p>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <li class="nav-item  menu-open">
                    <router-link to="#" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            {{ trans('lang.Types') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </router-link>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/mainTypes"
                                :class="$route.path === '/mainTypes' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Categories') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/units"
                                :class="$route.path === '/units' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Operation') }}</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/types" id="types"
                                :class="$route.path === '/types' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Types') }}</p>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <li class="nav-item  menu-open">
                    <router-link to="#" class="nav-link">
                        <i class="nav-icon fa fa-bar-chart"></i>
                        <p>
                            {{ trans('lang.Reports') }}
                            <i class="fas fa-angle-left right"></i>

                        </p>
                    </router-link>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/bills/report/daily"
                                :class="$route.path === '/bills/report/daily' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Today Report') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/bills/report/monthly"
                                :class="$route.path === '/bills/report/monthly' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Monthly Report') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/bills/report"
                                :class="$route.path === '/bills/report' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Period Report') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item ">
                            <router-link to="/appreport"
                                :class="$route.path === '/appreport' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Bills Report') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item ">
                            <router-link to="/TypeReport"
                                :class="$route.path === '/TypeReport' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Types Report') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item ">
                            <router-link to="/workerReport"
                                :class="$route.path === '/workerReport' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Workers Report') }}</p>
                            </router-link>
                        </li>
                        <li v-if="$root.$data.codies.country == 2" class="nav-item">
                            <router-link to="/ProcessReport"
                                :class="$route.path === '/ProcessReport' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Process Bills Report') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/customers/report"
                                :class="$route.path === '/customers/report' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Customers Report') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/search"
                                :class="$route.path === '/search' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Search Report') }}</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/shiftReport"
                                :class="$route.path === '/shiftReport' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Shift Report') }}</p>
                            </router-link>
                        </li>
                        <li class="nav-item d-none">
                            <router-link to="/attendance/report"
                                :class="$route.path === '/attendance/report' ?
                                    'nav-link  active' :
                                    'nav-link '">
                                <i class="fa  fa-info-circle nav-icon"></i>
                                <p>{{ trans('lang.Attendance And Leave report') }}</p>
                            </router-link>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <router-link to="/offers"
                        :class="$route.path === '/offers' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>
                            {{ trans('lang.Offers') }}
                        </p>
                    </router-link>

                </li>

                <li class="nav-item">
                    <router-link to="/stocks"
                        :class="$route.path === '/stocks' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fa fa-database"></i>
                        <p>
                            {{ trans('lang.Manage Stock') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item">
                    <router-link to="/gusto/stocks"
                        :class="$route.path === '/gusto/stocks' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fas fa-cubes"></i>
                        <p>
                            {{ trans('lang.Create Order') }}
                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/shift"
                        :class="$route.path === '/shift' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            {{ trans('lang.shifts') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item">
                    <router-link to="/cash"
                        :class="$route.path === '/cash' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fa fa-money"></i>
                        <p>
                            {{ trans('lang.Cash') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item">
                    <router-link to="/suppliers"
                        :class="$route.path === '/suppliers' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fa fa-truck"></i>
                        <p>
                            {{ trans('lang.Suppliers') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item">
                    <router-link to="/expenses"
                        :class="$route.path === '/expenses' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fa fa-minus-circle"></i>
                        <p>
                            {{ trans('lang.Expenses') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item">
                    <router-link to="/customers"
                        :class="$route.path === '/customers' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            {{ trans('lang.Customers') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item">
                    <router-link to="/workers"
                        :class="$route.path === '/workers' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            {{ trans('lang.Workers') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item">
                    <router-link to="/users"
                        :class="$route.path === '/users' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            {{ trans('lang.Users') }}
                        </p>
                    </router-link>

                </li>

                <li class="nav-item d-none">
                    <router-link to="/barcode"
                        :class="$route.path === '/barcode' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-barcode"></i>
                        <p>
                            {{ trans('lang.Barcode Settings') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item d-none">
                    <router-link to="/attendance"
                        :class="$route.path === '/attendance' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            {{ trans('lang.Attendance And Leave') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item">
                    <router-link to="/mixins"
                        :class="$route.path === '/mixins' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            {{ trans('lang.Settings') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item d-none">
                    <router-link to="{{ route('typesToExcel') }}"
                        :class="$route.path === '/typesToExcel' ?
                            'nav-link  active' :
                            'nav-link '">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            {{ trans('lang.Print') }}
                        </p>
                    </router-link>

                </li>
                <li class="nav-item bg-danger border-1">
                    <router-link to="/trash"
                        :class="$route.path === '/trash' ?
                            'nav-link  active ' :
                            'nav-link '">
                        <i class="nav-icon fas fa-trash "></i>
                        <p>
                            {{ trans('lang.Trash') }}
                        </p>
                    </router-link>

                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
