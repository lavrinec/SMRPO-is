<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/img/user.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                <a href="/users"><i class="fa fa-circle text-success"></i> Aktiven</a>
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
            @if(Auth::user()->isAdmin())
                <li class="{{ $routeGroup == 'users' ? 'active' : '' }}"><a href="/users"><i class="fa fa-users"></i> <span>Uporabniki</span></a>
            @endif
            </li>
            <li class="{{ $routeGroup == 'groups' ? 'active' : '' }}"><a href="/groups"><i class="fa fa-users"></i>
                    <span>Skupine</span></a></li>
            <li class="{{ $routeGroup == 'boards' ? 'active' : '' }}"><a href="/boards"><i class="fa fa-users"></i>
                    <span>Table</span></a></li>
            <li class="{{ $routeGroup == 'projects' ? 'active' : '' }}"><a href="/projects"><i class="fa fa-users"></i>
                    <span>Projekti</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>