<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Aomsin Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('products') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Product</span></a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="/profile">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Profile</span></a>
    </li>


    @if (Auth::user()->hasRole('Super-Admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ url('users') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>User Setting</span>
            </a>
        </li>
    @endif

    @if (Auth::user()->hasRole('Super-Admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ url('permissions') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Permission Setting</span>
            </a>
        </li>
    @endif



    @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super-Admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ url('roles') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Role Setting</span>
            </a>
        </li>
    @endif


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
