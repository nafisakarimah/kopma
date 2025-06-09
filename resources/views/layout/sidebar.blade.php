
<nav class="sidebar" id="sidebar">
    <div class="text-right p-3">
        <button type="button" class="navbar-toggler" id="btn-toggle-sidebar">
            <i class="fa fa-times text-primary"></i>
        </button>
    </div>
    {{-- <div class="text-right">
        <button type="button" class="navbar-toggler d-inline-block d-lg-none" id="btn-toggle-sidebar">
            <i class="fa fa-times"></i>
        </button>
    </div> --}}
    {{-- <span class="p-3 d-block text-muted">Main Menu</span> --}}
    <div class="sidebar-header">
        <a href="{{ url('') }}" class="sidebar-header-img" style="width: 100px;height: 100px;border-radius: 50%;overflow: hidden;display: block">
            <img src="{{ asset(auth()->user()->foto ? 'uploads/' . auth()->user()->foto : 'assets/img/fotoguest.png') }}" alt="" width="100%">
        </a>
        <h6 class="text-dark fw-bold">{{ auth()->user()->nama }}</h6>
    </div>
    <div class="sidebar-menu">
        <a href="{{ route('home') }}" class="menu-item">
            <i class="fa fa-home item-icon"></i> <span class="item-title">Beranda</span>
        </a>
        @if (auth()->user()->role == '1')
            <a href="{{ route('admin.pengguna') }}" class="menu-item{{ Request::segment(2) == 'pengguna'? ' active' : '' }}">
                <i class="fa fa-users item-icon"></i> <span class="item-title">User</span>
            </a>
            <a href="{{ route('admin.transaksi.index') }}" class="menu-item{{ Request::segment(2) == 'transaksi'? ' active' : '' }}">
                <i class="fa fa-file item-icon"></i> <span class="item-title">Transaksi</span>
            </a>
            {{-- <a href="{{ route('admin.member') }}" class="menu-item{{ Request::segment(2) == 'member'? ' active' : '' }}">
                <i class="fa fa-users item-icon"></i> <span class="item-title">Member</span>
            </a> --}}
            <a href="{{ route('admin.produk.index') }}" class="menu-item{{ Request::segment(2) == 'produk'? ' active' : '' }}">
                <i class="fa fa-box item-icon"></i> <span class="item-title">Produk</span>
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="menu-item{{ Request::segment(2) == 'kategori'? ' active' : '' }}">
                <i class="fa fa-list item-icon"></i> <span class="item-title">Kategori</span>
            </a>
            <a href="{{ route('admin.guskom.index') }}" class="menu-item{{ Request::segment(2) == 'guskom'? ' active' : '' }}">
                <i class="fa fa-users item-icon"></i> <span class="item-title">Guskom</span>
            </a>
            <a href="{{ route('admin.feedback.index') }}" class="menu-item{{ Request::segment(2) == 'feedback'? ' active' : '' }}">
                <i class="fa fa-comments item-icon"></i> <span class="item-title">Feedback</span>
            </a>
            <a href="{{ route('admin.faq.index') }}" class="menu-item{{ Request::segment(2) == 'faq'? ' active' : '' }}">
                <i class="fa fa-question item-icon"></i> <span class="item-title">FAQ</span>
            </a>
        @elseif(auth()->user()->role == '2')
            <a href="{{ route('user.profil.index') }}" class="menu-item{{ Request::segment(2) == 'profil'? ' active' : '' }}">
                <i class="fa fa-user item-icon"></i> <span class="item-title">Profil</span>
            </a>
            <a href="{{ route('user.transaksi.index') }}" class="menu-item{{ Request::segment(2) == 'transaksi'? ' active' : '' }}">
                <i class="fa fa-file-alt item-icon"></i> <span class="item-title">Transaksi</span>
            </a>
            <a href="{{ route('user.alamat-pengiriman.index') }}" class="menu-item{{ Request::segment(2) == 'alamat-pengiriman'? ' active' : '' }}">
                <i class="fa fa-map-marker-alt item-icon"></i> <span class="item-title">Alamat Pengiriman</span>
            </a>
        @endif
        <a href="{{ route('logout') }}" class="menu-item text-danger">
            <i class="fa fa-sign-out-alt item-icon"></i> <span class="item-title">Keluar</span>
        </a>
    </div>
</nav>
