<!DOCTYPE html>
<html>
  @include('demo_template.head')
<body style="overflow: hidden;">
<div id="contain" style="height:100%">
  <!-- sidebar -->
  @include('demo_template.sidebar')
<div id="cont" style="height:100%">
  <!-- content -->
  @yield('content')

  @yield('script')
</div>
</div>
</body>
</html>