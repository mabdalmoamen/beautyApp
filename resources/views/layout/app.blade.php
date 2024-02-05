@include('layout.header')
@include('layout.navbar')
<div class="content-wrapper"  dir="{{ App::getLocale() === 'en' ? 'ltr' : 'rtl' }}">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid ml-auto">

            @yield('content')

        </div>
    </section>
</div>
@include('layout.footer')
@yield('datatable-script')

@yield('scripts')
