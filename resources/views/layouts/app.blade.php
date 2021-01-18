<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <?php if ($_SERVER['HTTP_HOST'] == 'www.gemmalist.com'): ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145233168-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-145233168-3');
    </script>
    <?php endif ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GemmaList</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    GemmaList
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <!-- add list -->
                                <a class="nav-item" href="#new-list-container" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="new-list-container" title="Create new list">
                                    <i class="fas fa-plus"></i>
                                </a>

                                <!-- count number of archived lists -->
                                <?php $glistCount = 0 ?>
                                @foreach ($glists as $x)
                                    @if ($x->archived)
                                    <?php $glistCount += 1; ?>
                                    @endif
                                @endforeach <!-- end count --> 

                                @if ($glistCount)
                                <!-- view hidden lists -->

                                <a class="nav-item dropdown-toggle" id="archived-lists-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="View hidden lists">
                                    <i class="far fa-eye"></i>
                                </a>
                                @endif

                                <!-- delete all completed -->
                                <a class="nav-item" href="javascript:document.getElementById('delete-form').submit();" title="Delete Completed Tasks">
                                    <i class="far fa-trash-alt"></i>
                                </a>

                                <!-- sign out -->
                                <a class="nav-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>

                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <form id="delete-form" method="POST" action="/tasks">
                                    @method('DELETE')
                                    @csrf
                                </form>

                                <!-- archived lists -->
                                <div aria-labelledby="archived-lists-toggle" class="dropdown-menu" id="archived-items">
                                @foreach ($glists->sortBy('name') as $glist)
                                    @if ($glist->archived)

                                        <form class="un-archive" method="POST" action="/glists/{{ $glist->id }}/archive">
                                                    
                                            @csrf
                                            @method('PATCH')

                                            <button class="archived-item dropdown-item pl-3" type="submit">{{ $glist->name }}</button>
                                                
                                        </form>
                                    @endif
                                @endforeach
                                </div> <!-- end archived lists -->

                                <!-- add new list -->
                                <div class="collapse" id="new-list-container">

                                    <form action="/glists" class="font-small" method="POST">

                                        @csrf

                                        <input name="name" type="text" value="{{ old('name') }}" placeholder="add a new list" required>
                                        
                                        <button class="button list-add" type="submit">+</button>

                                    </form>

                                </div> <!-- end add new list -->

                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('js/touch-punch.js') }}"></script>
</body>
</html>
