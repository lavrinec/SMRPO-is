<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SMRPO informacijski sistem</title>
  <!-- Tell the browser to be responsive to screen width -->
  @include('dependencies.basic_head_link_dependencies')
</head>
<body class="hold-transition skin-blue sidebar-mini">
  @include('dependencies.global_js_functions')
  <div class="wrapper">


  @include('header.mainheader')

  @include('modals.documentation')

  <!-- Left side column. contains the logo and sidebar -->
    @include('sidebar.mainsidebar')

    <!-- Content Wrapper. Contains page content -->
    @yield('content')

    @include('footer.footer')

    @include('sidebar.controlsidebar')

  </div>
  <!-- ./wrapper -->

@include('dependencies.javascript_dependencies')
</body>
</html>
