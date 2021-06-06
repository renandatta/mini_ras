<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <link href="{{ asset('css/core.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    @stack('plugins')

    <link href="{{ asset('css/autocomplete.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app">
        @yield('body')
        @stack('modals')
    </div>
    <script src="{{ asset('assets/js/core.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/autoNumeric.js') }}"></script>
    <script src="{{ asset('assets/js/autocomplete.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script>
        let init_form_element = () => {
            $(".select2").select2();
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
            $(".timepicker").timepicker({
                showMeridian: false,
                showSeconds: true,
                icons: { up: "mdi mdi-chevron-up", down: "mdi mdi-chevron-down" },
            });
            $(".summernote").summernote({
                height: 300,
            });
            $('.dropify').dropify();
            $('.autonumeric')
                .attr('data-a-sep', '.')
                .attr('data-a-dec',',')
                .autoNumeric({
                    mDec: '0',
                    vMax:'9999999999999999999999999',
                    vMin: '-99999999999999999'
                });
            $('.autonumeric-decimal')
                .attr('data-a-sep','.')
                .attr('data-a-dec',',')
                .autoNumeric({
                    mDec: '2',
                    vMax:'999'
                });
        }
        $("[data-hide]").on("click", function(){
            $(this).parent().hide();
        });
        let get_form_data = ($form) => {
            let unindexed_array = $form.serializeArray();
            let indexed_array = {};
            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });
            return indexed_array;
        }
        let display_error = (target_id, errors) => {
            let $target = $('#' + target_id);
            let $content = $('#' + target_id + '_content');
            $content.html('');
            $.each(errors, (i, value) => {
                $content.append('<li>'+ value +'</li>');
            });
            $target.show();
        }
        let add_commas = (nStr) => {
            nStr += '';
            let x = nStr.split('.');
            let x1 = x[0];
            let x2 = x.length > 1 ? '.' + x[1] : '';
            let rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
        let remove_commas = (nStr) => {
            nStr = nStr.replace(/\./g,'');
            return nStr;
        }
        let toggle_alert = (id) => {
            let x = document.getElementById(id);
            if (x.style.display === "none") x.style.display = "block";
            else x.style.display = "none";
        }
    </script>
    @stack('scripts')
</body>
</html>
