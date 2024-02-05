<!-- /.content-wrapper -->
<footer class="main-footer text-center" >
    <strong>{{ trans('lang.Contact With') }}
        <a href="https://codies-eg.surge.sh/">{{ trans('lang.Gusto') }}</a>:
    </strong>
    @if ($codies && $codies->country == 2)
        <span class="mx-2" style="direction: ltr"><a href="https://api.whatsapp.com/send?phone=966557179844"
                target="_blank">
                <i class="fa fa-whatsapp mr-1"></i>
                966557179844+</a></span>
        <span class="mx-2" style="direction: ltr"><a href="https://api.whatsapp.com/send?phone=966561420027"
                target="_blank"><i class="fa fa-whatsapp  mr-1"></i>
                966561420027+ </a></span>
    @else
        <span class="mx-2" style="direction: ltr"><a href="https://api.whatsapp.com/send?phone=201002208627"
                target="_blank">
                <i class="fa fa-whatsapp mr-1"></i>
                201002208627+</a></span>
        <span class="mx-2" style="direction: ltr"><a href="https://api.whatsapp.com/send?phone=201009199086"
                target="_blank"><i class="fa fa-whatsapp  mr-1"></i>
                201009199086+ </a></span>
    @endif
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.2
    </div>


</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->
@include('layout.script')
