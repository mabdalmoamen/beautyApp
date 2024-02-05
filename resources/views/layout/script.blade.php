<script>
    let lang = {!! json_encode(App::getLocale()) !!}
    localStorage.setItem('lang', lang);
</script>
<script>
    //Make the DIV element draggagle:
    // dragElement();

    function dragElement(id) {
        let elmnt = document.getElementById(id);
        var pos1 = 0,
            pos2 = 0,
            pos3 = 0,
            pos4 = 0;
        if (document.getElementById(elmnt.id + "header")) {
            /* if present, the header is where you move the DIV from:*/
            document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
        } else {
            /* otherwise, move the DIV from anywhere inside the DIV:*/
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            // set the element's new position:
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            /* stop moving when mouse button is released:*/
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
</script>

<script src="{{ mix('js/app.js') }}"></script>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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
<script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>
<script src="{{ asset('js/event.js') }}"></script>
<script src="{{ asset('js/tablesExcel.js') }}"></script>

<script type="text/javascript">
    let token = localStorage.getItem('token');
    if (token) {
        $("nav").css("display", "");
        $("aside").css("display", "");
    }

    $(function($) {
        $('.dropdown-toggle').dropdown()
            $('.text-primary').addClass('btn')

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
</script>

<script>

    function go_full_screen() {

        var elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        }
    }
</script>

</body>

</html>
