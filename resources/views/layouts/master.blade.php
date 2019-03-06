<!doctype html>
<html lang="en" dir="ltr">
  @yield('top-css')
  @include('layouts.partials.head')
  <body class="">
    <div class="page">
      <div class="page-main">
        @include('layouts.partials.top_menu')
        @include('layouts.partials.main_menu')
        <div class="my-3 my-md-5">
          @yield('content')
        </div>
      </div>
        @include('layouts.partials.footer')
    </div>

    <script type="text/javascript" src="/assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/core.js"></script>
    <script type="text/javascript" src="/assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript">
      var baseuri = {!! json_encode(url('/')) !!};
    </script>
    <script type="text/javascript" src="/js/helpers.js"></script>
    @yield('js')
  </body>
</html>
