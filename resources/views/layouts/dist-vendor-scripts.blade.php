<!-- JS here -->
{{-- <script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script> --}}
<script src="{{ URL::asset('dist/js/jquery-min.js') }}"></script>
<script src="{{ URL::asset('dist/js/bootstrap.min.js') }}"></script>
{{-- <script src="{{ URL::asset('dist/js/nice-select.js') }}"></script> --}}
<script src="{{ URL::asset('dist/js/magnific-popup.js') }}"></script>
<script src="{{ URL::asset('dist/js/range-slider.js') }}"></script>
<script src="{{ URL::asset('dist/js/swiper-min.js') }}"></script>
<script src="{{ URL::asset('dist/js/wow.js') }}"></script>
<!-- TOASTR -->
<script src="{{ URL::asset('build/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ URL::asset('dist/js/countdown.js') }}"></script>
<script src="{{ URL::asset('dist/js/mobile-menu-scripts.js') }}"></script>
<script src="{{ URL::asset('dist/js/main.js') }}"></script>

<script type="text/javascript">
    @if (session()->has('success'))
        toastr.success('{{ session('success') }}')
    @elseif (session()->has('error'))
        toastr.error('{{ session('error') }}')
    @endif
</script>
@yield('script')
@yield('script-bottom')
