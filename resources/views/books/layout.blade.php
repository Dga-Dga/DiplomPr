 <body>
    <div class="container">
        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
<footer>
    @include('includes.footer')
</footer>