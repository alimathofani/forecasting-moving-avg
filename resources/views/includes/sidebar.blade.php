<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="{{ url('/') }}">
        <i class="fas fa-fw fa-poll"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
        <i class="fas fa-fw fa-chart-line"></i>
        <span>Forecasting</span></a>
    </li>

     <!-- Nav Item - Tables -->
     <li class="nav-item {{ request()->is('hasil') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('hasil.index') }}">
        <i class="fas fa-fw fa-diagnoses"></i>
        <span>Hasil</span></a>
    </li>
    

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('items') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('items.index') }}">
        <i class="fas fa-fw fa-align-justify"></i>
        <span>Master Barang</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('settings') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('settings.index') }}">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Periode</span></a>
    </li>

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