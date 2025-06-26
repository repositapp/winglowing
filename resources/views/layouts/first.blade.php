<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from template.moontelict.com/rosun/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Jun 2025 04:46:23 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ $aplikasi->title_header }} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ URL::asset('build/dist/img/favicon.png') }}">

    @include('layouts.dist-head-css')
</head>

<body>
    @include('layouts.dist-customizer')

    @include('layouts.dist-sidebar')

    {{-- @include('layouts.dist-cart-mini') --}}

    @include('layouts.dist-topbar')

    <main>

        @yield('content')

    </main>

    @include('layouts.dist-footer')

    @include('layouts.dist-vendor-scripts')
</body>

</html>
