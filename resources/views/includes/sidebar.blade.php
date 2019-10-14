<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('forecasting') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('forecasting.index') }}">
        <i class="fas fa-fw fa-poll"></i>
        <span>Forecasting</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Report
    </div>

     <!-- Nav Item - Tables -->
     <li class="nav-item {{ request()->is('results') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('result.index') }}">
        <i class="fas fa-fw fa-diagnoses"></i>
        <span>List Hasil Akhir</span></a>
    </li>

    @role('owner,admin')
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan
    </div>

        @role('owner')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-user-friends"></i>
                <span>User Management</span>
            </a>
            <div id="collapsePages" class="collapse 
            {{ request()->is('users') || request()->is('users/*') || request()->is('roles') || request()->is('roles/*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('users') || request()->is('users/*') ? 'active' : '' }}" href="{{ route('users.index') }}">Master User </a>
                    <a class="collapse-item {{ request()->is('roles') || request()->is('roles/*')? 'active' : '' }}" href="{{ route('roles.index') }}">Master Role</a>
                </div>
            </div>
        </li>
        @endrole

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('items') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('items.index') }}">
        <i class="fas fa-fw fa-align-justify"></i>
        <span>Master Barang</span></a>
    </li>

        @role('owner')
        <!-- Nav Item - Tables -->
        <li class="nav-item {{ request()->is('settings') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('settings.index') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pengaturan</span></a>
        </li>
        @endrole
    @endrole

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->