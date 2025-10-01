<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RME RSUD Langsa &mdash; {{ $title ?? 'Home' }}</title>

    {{-- cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    {{-- icon to bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- Bootstrap Bundle JS (termasuk Popper.js) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> --}}


    {{-- local --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-override.min.css') }}">
    <link rel="stylesheet" id="theme-color" href="{{ asset('assets/css/dark.min.css') }}">
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <link href="{{ asset('vendor/select2-bootstrap-5-theme/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <!-- CSS for this page only -->
    @stack('css')
    <!-- End CSS  -->

    {{-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script> --}}


    {{-- vite --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    {{-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script> --}}

</head>

<body>
    <div id="app">
        @include('layouts.administrator.notif-session')

        @include('layouts.administrator.header')

        @include('layouts.administrator.navigation')

        @include('layouts.administrator.content')

        @include('layouts.administrator.setting')

        @include('layouts.administrator.footer')
    </div>

    @stack('modals')

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    {{-- signature pad lemonadejs --}}
    <script src="https://cdn.jsdelivr.net/npm/lemonadejs/dist/lemonade.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@lemonadejs/signature/dist/index.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        Main.init();
    </script>

    <script>
        function showToast(type, message) {
            iziToast[type]({
                title: type,
                message: message,
                position: 'topRight',
                timeout: 3000,
                progressBar: true,
                displayMode: 'once',
            });
        }

        // ============================================
        // SETUP GLOBAL AJAX - CSRF TOKEN
        // ============================================
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ============================================
        // KEEP SESSION ALIVE - Ping setiap 5 menit
        // ============================================
        setInterval(function() {
            $.ajax({
                url: '/keep-alive',
                method: 'GET',
                success: function(response) {
                    if (response.token) {
                        $('meta[name="csrf-token"]').attr('content', response.token);
                    }

                },
                error: function() {
                    console.warn('⚠️ Failed to refresh session');
                }
            });
        }, 5 * 60 * 1000); // 5 menit
    </script>

    <!-- js for this page only -->
    @stack('js')
    @stack('scripts')
    <!-- ======= -->
</body>

</html>
