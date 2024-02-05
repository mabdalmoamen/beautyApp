<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<script src="{{ mix('js/app.js') }}"></script>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
@if (App::getLocale() === 'en')
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@else
    <!-- Bootstrap 4 rtl -->
    <script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"></script>
@endif
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- DataTables  & Plugins -->

<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>

<script src="{{ asset('js/cashier.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script type="text/javascript">
    $('.userName').text(localStorage.getItem('user'))
    let token = localStorage.getItem('token');
    if (token) {
        $("nav").css("display", "");
        $("aside").css("display", "");
    }
    $(function($) {
        $(" tr").on('click', function() {
            $(this).addClass('selectedRow').siblings().removeClass('selectedRow')
        });
        $(".modal").draggable({
            handle: ".modal-header"
        });

        var string = "";
        var timeout;
        var lastEventTime = 0;

        // ADJUST THOSE TWO!
        var threshold = 35;
        var outputDelay = 100;

        $('.barCodeNum').on("keydown", function(e) {
            e.preventDefault();
            var codebarInput = $(this);
            // Get current time.
            var thisEventTime = Date.now();

            // Grab the character.
            string += String.fromCharCode(e.keyCode)

            // If this event occurs sooner than the threshold delay, use the timeout to output the value when all characters are in string.
            if (lastEventTime + threshold > thisEventTime) {
                // Output the string after a delay.
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    codebarInput.val(string);
                }, outputDelay);

                // If this event occurs after the threshold delay, clear string and input value.
            } else {

                codebarInput.val("");
                string = "";
            }


            // Keep this event time.
            lastEventTime = thisEventTime;

        }); // End keydown


    })

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires;
    }
</script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

{{-- Print --}}
<script>
    $.fn.dataTable.ext.errMode = 'none';
</script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
</body>

</html>
