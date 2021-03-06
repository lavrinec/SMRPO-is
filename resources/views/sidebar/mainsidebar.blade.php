<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        @if($user = Auth::user())
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/img/user.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                        <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                        <a href="/users"><i class="fa fa-circle text-success"></i> Aktiven</a>
                </div>
            </div>
        @endif
        @php
            $route = Route::current();
            $routeName = isset($route) ? $route->getName() : '';
            $routeGroup = explode('.', $routeName)[0];
        @endphp
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGACIJA</li>
            <li class="{{ ($routeGroup == '' || $routeGroup == 'dashboard' || $routeGroup == 'home') ? 'active' : '' }}">
                <a href="/">
                    <i class="fa fa-dashboard"></i> <span>Domov</span>
                </a>
            </li>
            @if($user = Auth::user())
                @if($user->isAdmin())
                    <li class="{{ $routeGroup == 'users' ? 'active' : '' }}"><a href="/users"><i class="fa fa-user"></i> <span>Uporabniki</span></a>
                @endif
                </li>
                    <li class="{{ $routeGroup == 'groups' ? 'active' : '' }}"><a href="/groups"><i class="fa fa-users"></i>
                            <span>Skupine</span></a></li>
                <li class="{{ $routeGroup == 'boards' ? 'active' : '' }}"><a href="/boards"><i class="fa fa-table"></i>
                        <span>Table</span></a></li>
                <li class="{{ $routeGroup == 'projects' ? 'active' : '' }}"><a href="/projects"><i class="fa fa-briefcase"></i>
                        <span>Projekti</span></a></li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>