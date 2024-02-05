<!DOCTYPE html>
<html lang="{{ Cookie::get('locale') }}
" dir="{{ Cookie::get('locale')=="en"?'ltr':'rtl' }}">
@include('header.header')

<body id="page-top">
    <div id="app">
        <div id="wrapper">
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <div id="container-wrapper container-fluid">

                      {{$bills}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer.footer')
</body>

</html>
