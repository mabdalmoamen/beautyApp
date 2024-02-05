<!-- Sidebar -->

<nav id="navbar" v-show="$route.path==='/'?false:true" style="display: none">
    <ul class="navbar-nav sidebar  sidebar-light accordion toggled hideMeInPrint"  id="accordionSidebar">
        <li class="nav-item  active">
            <router-link class="nav-link" to="/home">
                <p class="my-0 fa userName"></p>
            </router-link>

        </li>
        <li :class="$route.path==='/home'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/home">
                <i class="fa fa-home" title="الرئيسية-Home"></i>
            </router-link>
        </li>
        <li :class="$route.path==='/shift'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/shift">
                <i class="fa fa-dollar-sign" title="الوردية-Shift"></i>
            </router-link>
        </li>
        <li :class="$route.path==='/bill'?'nav-item  active' :'nav-item '" v-show="$root.$data.mixins.bill_type===1">
            <router-link class="nav-link" to="/bill">
                <i class="fas fa-file-invoice-dollar" title="الفواتير - Bills"></i>
            </router-link>
        </li>

        <li :class="$route.path==='/bills'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/bills">
                <i class="fa fa-wallet" title="الفواتير-Bills"></i>
                <span>{{__('Sales Bill')}}</span>
            </router-link>
        </li>
        <li :class="$route.path==='/users'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/users">
                <i class="fa fa-users" title="المستخدمون-Users"></i>
                <span>{{__('Users')}}</span>
            </router-link>
        </li>
        <li :class="$route.path==='/customers'?'nav-item  active' :'nav-item '" v-show="$root.$data.roles.includes(10)">
            <router-link class="nav-link" to="/customers">
                <i class="fa fa-users-cog" title="العملاء-Customers"></i>
                <span>{{__('Customers')}}</span>
            </router-link>
        </li>

        <li class="nav-item  d-none">
            <router-link class="nav-link" to="/purchase-bills">
                <i class="fa fa-receipt" title="فاتورة شراء-Purchase Bill"></i>
                <span>{{__('Purchase Bill')}}</span>
            </router-link>
        </li>
        <li class="nav-item active d-none">
            <router-link class="nav-link" to="/allPurchaseBills">
                <i class="fa fa-landmark" title="فواتير الشراء-Purchase Bills"></i>
                <span>{{__('Purchase Bills')}}</span>
            </router-link>
        </li>
        <li :class="$route.path==='/suppliers'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/suppliers">
                <i class="fa fa-truck" title="الموردون-Suppliers"></i>
                <span>{{__('Suppliers')}}</span>
            </router-link>
        </li>

        <li :class="$route.path==='/types'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/types">
                <i class="fa fa-list" title="الأصناف-Types"></i>
                <span>{{__('Types')}}</span>
            </router-link>
        </li>
        <li :class="$route.path==='/workers'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/workers">
                <i class="fa fa-user-circle" title="الموظفون-Workers"></i>
                <span>{{ __('Workers') }}</span>
            </router-link>
        </li>
        <li :class="$route.path==='/mainTypes'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/mainTypes">
                <i class="fa fa-th" title="التصنيفات-Categories"></i>
                <span>{{__('Catergories')}}</span>
            </router-link>
        </li>
        <li :class="$route.path==='/report'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/report">
                <i class="fa fa-chart-line" title="التقارير-Reports"></i>
                <span>{{__('Reports')}}</span>
            </router-link>
        </li>
        <li :class="$route.path==='/mixins'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/mixins">
                <i class="fa fa-cog" title="الاعدادات-Settings"></i>
                <span>{{__('Settings')}}</span>
            </router-link>
        </li>
        <li :class="$route.path==='/logout'?'nav-item  active' :'nav-item '">
            <router-link class="nav-link" to="/logout">
                <i class="fas fa-sign-out-alt" title="خروج-Exit"></i>
                <span> {{__('Exit')}}</span>

            </router-link>
        </li>
    </ul>

</nav>
<!-- Sidebar -->
