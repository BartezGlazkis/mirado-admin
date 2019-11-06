<!doctype html>
<html>

<head>
    @include('includes.head')
</head>

<body class="bg-white">

    @include('includes.header')

    <div class="wrapper d-flex">
        @if (auth()->check())
        @if (auth()->user()->is('admin'))
        @include('includes.admin-sidebar')
        @else
        @include('includes.sidebar')
        @endif
        @endif
        
        <div id="app" class="content p-3 p-md-5">
            @yield('content')
        </div>
    </div>
    <!-- <footer>
            @include('includes.footer')
        </footer> -->
</body>

</html>