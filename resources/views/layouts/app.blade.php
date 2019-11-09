<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{config('app.name', 'Aston CS Allocation System') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div id="app">
        <nav class="bg-blue-900 shadow mb-8 py-6">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-center">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                            {{ config('app.name', 'Allocation System') }}
                        </a>
                    </div>
                    <div class="flex-1 text-right">
                        @guest
                            <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            @if(Auth::user()->role === "Supervisor" )
                                <a href="{{route('topics.create')}}" class="no-underline hover:underline text-gray-300 text-sm p-3">Create a Topic</a>
                                <a href="#" class="no-underline hover:underline text-gray-300 text-sm p-3">View Proposal Requests</a>
                                
                            @elseif(Auth::user()->role === "Module Leader")
                                <a href="{{route('topics.create')}}" class="no-underline hover:underline text-gray-300 text-sm p-3">Create a Topic</a>
                                <a href="#" class="no-underline hover:underline text-gray-300 text-sm p-3">View Proposal Requests</a>
                                <a href="#" class="no-underline hover:underline text-gray-300 text-sm p-3">All Allocations</a>
                            @else
                                <a href="#" class="no-underline hover:underline text-gray-300 text-sm p-3">My Allocations</a>
                                <a href="#" class="no-underline hover:underline text-gray-300 text-sm p-3">My Choices</a>
                                <a href="#" class="no-underline hover:underline text-gray-300 text-sm p-3">Create a Proposal</a>
                            @endif
                            <!-- <span class="text-gray-300 text-sm pr-4">{{ Auth::user()->name }}</span> -->
                            
                            <a href="{{ route('logout') }}"
                               class="no-underline hover:underline text-gray-300 text-sm p-3"
                               onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
