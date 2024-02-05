@extends('layout.app')
@section('content')
    {!! $dataTable->table() !!}
@endsection
@section('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $.fn.dataTable.ext.errMode = 'none';
    </script>
    <script>
        $(function() {
            function getUrlParameter(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }
            if (getUrlParameter('period') == 'period' && getUrlParameter('to') === '' &&
                getUrlParameter(
                    'from') === '') {
                $('.alert-danger').css('display', 'block');

            }
            $('select').on('change', function(e) {
                $('.alert-danger').fadeOut();
                document.forms['form'].submit();

            });

        })
    </script>
@endsection
