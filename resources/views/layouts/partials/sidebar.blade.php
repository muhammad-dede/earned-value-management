<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('beranda') }}" class="brand-link elevation-4">
        <img src="{{ asset('favicon.png') }}" alt="logo" class="brand-image elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/profil') }}/{{ auth()->user()->image_profil }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                @if (auth()->user()->role->role == 'Vendor')
                    <a href="#" class="d-block">{{ auth()->user()->vendor->nama }}</a>
                @else
                    <a href="#" class="d-block">{{ auth()->user()->pegawai->nama }}</a>
                @endif
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('beranda') }}" class="nav-link {{ $menu == 'beranda' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                @if (auth()->user()->role->role == 'Super Admin')
                    <li class="nav-header">MASTER</li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link {{ $menu == 'user' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pegawai.index') }}"
                            class="nav-link {{ $menu == 'pegawai' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Pegawai
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vendor-pt.index') }}"
                            class="nav-link {{ $menu == 'vendor_pt' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                Vendor PT
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vendors.index') }}"
                            class="nav-link {{ $menu == 'vendor' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book-reader"></i>
                            <p>
                                Vendor
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-header">UTAMA</li>
                <li class="nav-item">
                    <a href="{{ route('projek.index') }}"
                        class="nav-link {{ $menu == 'projek' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Projek
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}"
                        class="nav-link {{ $menu == 'laporan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>
                <br>
                <br>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
