<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('core::components.layouts.head')
    @stack('styles')
    
</head>

<body>

    {{-- TOP --}}
    @include('core::components.layouts.top')

    <div class="app-wrapper">

        {{-- LEFT --}}
        @include('core::components.layouts.left')

        {{-- MAIN --}}
        <main class="app-content">

            @include('core::components.layouts.state_msg')

            @yield('content')

        </main>

        {{-- RIGHT --}}
        @include('core::components.layouts.right')

    </div>

    @include('core::components.layouts.script')
    @stack('scripts')

</body>

</html>
