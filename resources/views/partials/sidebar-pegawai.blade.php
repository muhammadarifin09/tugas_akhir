{{-- resources/views/partials/sidebar-pegawai.blade.php --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('pegawai.dashboard') }}" class="brand-link">

        <span class="brand-text font-weight-light">Pegawai Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Pegawai' }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" 
                data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="{{ route('pegawai.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pegawai.meja.index') }}" 
                       class="nav-link {{ request()->routeIs('pegawai.meja.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chair"></i>
                        <p>Data Meja</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pegawai.produk.index') }}" 
                       class="nav-link {{ request()->routeIs('pegawai.produk.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-utensils"></i>
                        <p>Data Produk</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pegawai.pesanan.index') }}" 
                       class="nav-link {{ request()->routeIs('pegawai.pesanan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-first-order"></i>
                        <p>Data Pesanan</p>
                    </a>
                </li>
           

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-left" style="color:#c2c7d0;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
