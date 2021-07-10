        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle"
                        width="50">
                </div>
                <div class="sidebar-brand-text mx-3"> Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('nilai.index')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Data Tunggal</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/bergolong">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <span>Data bergolong</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/chi">
                    <i class="fa fa-list" aria-hidden="true"></i>
                    <span>Chi-Kuadrat</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/liliefors">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    <span>Liliefors</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('produkmoment.index')}}">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    <span>produk moment</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('pointbiserial.index')}}">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    <span>point biserial</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('ujit.index')}}">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    <span>Uji T</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('anava.index')}}">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    <span>Uji anava</span></a>
            </li>



            <!-- Divider
            <hr class="sidebar-divider"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                proscessing data
            </div>

            <li class="nav-item">
                <a class="nav-link" href="/proses/add">
                    <i class="fa fa-pencil-square-o"></i>
                    <span>Tambah Data</span></a>
            </li> -->

            <!-- Nav Item - Pages Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-bar-chart"></i>
                    <span>Operasi Data</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">OPERASI</h6>
                        <a class="collapse-item" href="/proses/mean">Rata - Rata</a>
                        <a class="collapse-item" href="/proses/count">Frekuensi 1</a>
                        <a class="collapse-item" href="/proses/countnew">Frekuensi 2</a>
                        <a class="collapse-item" href="/proses/max">Maximum</a>
                        <a class="collapse-item" href="/proses/min">Minimum</a>
                    </div>
                </div>
            </li> -->



        </ul>