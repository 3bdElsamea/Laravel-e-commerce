<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">


    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ 'Orders' }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif


                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link mx-4" href="{{route('notifications')}}" role="button" >
                                    <i class="fa-solid fa-bell"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link " href="#" role="button"  aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

    @if(auth()->check())
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                Echo.private(`AdminsChannel`).listen('OrderCreatedEvent', (e) => {
                    // console.log(e);
                    Swal.fire({
                        text: e.msg,
                        timer: 3000,
                        showConfirmButton: false,
                        position: 'bottom-end',
                    })
                });

            });
            {{--document.addEventListener("DOMContentLoaded", function(event) {--}}
            {{--    Echo.private(`private-App.Models.User.{{ auth()->id() }}`  )--}}
            {{--        .notification((notification) => {--}}
            {{--            Swal.fire({--}}
            {{--                title: "New Order",--}}
            {{--                text: notification.message,--}}
            {{--                // icon: 'success',--}}
            {{--                timer: 3000,--}}
            {{--                showConfirmButton: false,--}}
            {{--                position: 'bottom-end',--}}
            {{--            })--}}
            {{--        });--}}
            {{--});--}}

        </script>
        @endif
    </div>
</body>
</html>
