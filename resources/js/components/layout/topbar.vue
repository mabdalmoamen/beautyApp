<template>
    <!-- TopBar -->

    <nav
        class="navbar navbar-expand navbar-light bg-navbar my-0 py-0 static-top"
        v-show="$route.path === '/' ? false : true"
    >
        <a id="sidebarToggleTop" class="btn btn-link mr-3 text-light">
            <i class="fa fa-bars"></i>
        </a>

        <ul class="navbar-nav m-auto">
            <li class="nav-item active">
                <router-link class="nav-link" to="/create/type">
                    <span class="ml-2 d-none d-lg-inline text-white">{{
                        __("Add Type")
                    }}</span>
                </router-link>
            </li>

            <li class="nav-item active">
                <router-link class="nav-link" to="/processing">
                    <span class="ml-2 d-none d-lg-inline text-white">{{
                        __("Process Bill")
                    }}</span>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link class="nav-link" to="/create/customer">
                    <span class="ml-2 d-none d-lg-inline text-white">{{
                        __("Add Customer")
                    }}</span>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link class="nav-link" to="/create/supplier">
                    <span class="ml-2 d-none d-lg-inline text-white">{{
                        __("Add Supplier")
                    }}</span>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link class="nav-link" to="/purchase-bills">
                    <span class="ml-2 d-none d-lg-inline text-white">{{
                        __("Purchase Bill")
                    }}</span>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link class="nav-link" to="/report">
                    <span class="ml-2 d-none d-lg-inline text-white"
                        >{{ __("Reports") }}
                    </span>
                </router-link>
            </li>

            <li class="nav-item active">
                <router-link class="nav-link" to="/logout">
                    <span class="ml-2 d-none d-lg-inline text-white">
                        {{ __("Exit") }}</span
                    >
                </router-link>
            </li>
        </ul>
    </nav>

    <!-- Topbar -->
</template>

<script>
export default {
    name: "topbar",
};
</script>
