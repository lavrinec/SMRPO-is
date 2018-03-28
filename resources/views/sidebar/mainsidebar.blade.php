<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Ime Prijavljenega Uporabnika</p>
          <a href="/users"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
        @php
            $route = Route::current()->getName();
            $routeGroup = explode('.', $route)[0];
        @endphp
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGACIJA</li>
        <li class="{{ ($routeGroup == '' || $routeGroup == 'dashboard' || $routeGroup == 'home') ? 'active' : '' }}">
          <a href="/">
            <i class="fa fa-dashboard"></i> <span>Domov</span>
          </a>
        </li>
        <li class="{{ $routeGroup == 'users' ? 'active' : '' }}"><a href="/users"><i class="fa fa-users"></i> <span>Uporabniki</span></a></li>
        <li class="{{ $routeGroup == 'boards' ? 'active' : '' }}"><a href="/boards"><i class="fa fa-users"></i> <span>Table</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>