<!DOCTYPE html>
<html>
  @include('draw_template.head')
<body>
<div id="contain" style="height:100%">
  <!-- sidebar -->
  @include('draw_template.sidebar')
<div id="cont" style="height:100%">
  <!-- content -->
  @yield('content')

  @yield('script')
</div>
</div>
</body>
</html>