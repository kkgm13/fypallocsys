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
    @yield('css')
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div id="app">
        <nav class="flex items-center justify-between flex-wrap bg-purple-600 shadow mb-8 py-6">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-center">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                            {{ config('app.name', 'Aston CS FYP Allocation System') }}
                        </a>
                    </div>
                    <div class="block md:hidden">
                        <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white" onclick="toggle()">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                        </button>
                    </div>
                    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                        <div class="text-right lg:flex-grow">
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
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        const menu = document.getElementById('menu');
        const toggle = () => menu.classList.toggle("hidden");
    </script>
    @yield('js')
</body>
</html>
