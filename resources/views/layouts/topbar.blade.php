<!-- TopBar -->

<nav class="navbar navbar-expand navbar-light bg-navbar  my-0 py-0 static-top" v-show="$route.path==='/'?false:true">

        <a id="sidebarToggleTop" class="btn btn-link mr-3 text-light" >
            <i class="fa fa-bars"></i>
        </a>

    <ul class="navbar-nav m-auto">
    @if (Cookie::get('locale') !== null)
        <li class="nav-item active">
            <router-link class="nav-link" to="/create/type">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( Cookie::get('locale') .'.Add Type')}}</span>
            </router-link>
        </li>

        <li class="nav-item active" >
            <router-link class="nav-link" to="/processing">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( Cookie::get('locale') .'.Process Bill')}}</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/create/customer">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( Cookie::get('locale') .'.Add Customer')}}</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/create/supplier">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( Cookie::get('locale') .'.Add Supplier')}}</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/purchase-bills">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( Cookie::get('locale') .'.Purchase Bill')}}</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/reports">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( Cookie::get('locale') .'.Reports')}} </span>
            </router-link>
        </li>


        <li class="nav-item active" >
            <router-link class="nav-link" to="/logout">
                <span class="ml-2 d-none d-lg-inline text-white "> {{__(Cookie::get('locale') .'.Exit')}}</span>

            </router-link>
        </li>
        @else
        <li class="nav-item active">
            <router-link class="nav-link" to="/create/type">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( 'ar.Add Type')}}</span>
            </router-link>
        </li>

        <li class="nav-item active" >
            <router-link class="nav-link" to="/processing">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( 'ar.Process Bill')}}</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/create/customer">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( 'ar.Add Customer')}}</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/create/supplier">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( 'ar.Add Supplier')}}</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/purchase-bills">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( 'ar.Purchase Bill')}}</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/reports">
                <span class="ml-2 d-none d-lg-inline text-white ">{{ __( 'ar.Reports')}} </span>
            </router-link>
        </li>


        <li class="nav-item active" >
            <router-link class="nav-link" to="/logout">
                <span class="ml-2 d-none d-lg-inline text-white "> {{__('ar.Exit')}}</span>

            </router-link>
        </li>
        @endif
    </ul>
</nav>
{{--<div class="fixed-bottom footer">--}}
{{--    <div class="dock">--}}
{{--        <ul class="dock-container">--}}
{{--            <li>--}}
{{--                <router-link to="/home">--}}
{{--                    <div class="name">الرئيسية</div>--}}
{{--                    <img class="ico" src="{{asset('backend/img/footer/home.png')}}" alt="">--}}
{{--                </router-link>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <router-link to="/report">--}}
{{--                    <div class="name">الرئيسية</div>--}}
{{--                    <img class="ico" src="{{asset('backend/img/reports/report.png')}}" alt="">--}}
{{--                </router-link>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Topbar -->
