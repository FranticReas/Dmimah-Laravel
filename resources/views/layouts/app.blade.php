<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dmamah | @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        [v-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="wrapper" id="app" v-cloak>

        @include('partials.sidebar')

        <div class="main">
            @include('partials.navbar')

            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show mx-4 mt-3 mb-0 fade-up" role="alert">
                    <ion-icon name="checkmark-circle-outline" style="vertical-align:middle;margin-right:6px;"></ion-icon>
                    {{ Session::get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3 mb-0 fade-up" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <main class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>

            @include('partials.footer')
        </div>
    </div>

    @stack('modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
    <script>
        // Force white text on DataTables active page button
        // CSS alone can't always win against DataTables' own cascade
        (function () {
            function fixCurrentBtn() {
                document.querySelectorAll('.paginate_button.current').forEach(btn => {
                    btn.style.setProperty('color', '#ffffff', 'important');
                });
            }
            document.addEventListener('DOMContentLoaded', function () {
                fixCurrentBtn();
                // Re-apply on every pagination click
                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('paginate_button')) {
                        setTimeout(fixCurrentBtn, 10);
                    }
                });
                // Watch for DOM changes (DataTables rebuilds pagination on sort/filter)
                const observer = new MutationObserver(fixCurrentBtn);
                document.querySelectorAll('.dataTables_wrapper').forEach(wrapper => {
                    observer.observe(wrapper, { subtree: true, childList: true });
                });
            });
        })();
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>