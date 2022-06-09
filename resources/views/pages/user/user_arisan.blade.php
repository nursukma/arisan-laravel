<?php
use Symfony\Component\Console\Input\Input;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Laravel</title>
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="../assets/css/argon.css?v=1.2.0" type="text/css">
</head>

<body>
    {{$count=1;}}
    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
                </a>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        @if(auth()->user()->role == "admin")
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('peserta.index') }}">
                              <i class="ni ni-bullet-list-67 text-default"></i>
                              <span class="nav-link-text">Peserta</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('arisan.index') }}">
                              <i class="ni ni-bullet-list-67 text-default"></i>
                              <span class="nav-link-text">Arisan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kelompok_arisan.index') }}">
                              <i class="ni ni-bullet-list-67 text-default"></i>
                              <span class="nav-link-text">Kelompok Arisan</span>
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user_arisan.index') }}">
                              <i class="ni ni-bullet-list-67 text-default"></i>
                              <span class="nav-link-text">Arisan</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="/showHistory/"{{$pesertas}}>
                              <i class="ni ni-bullet-list-67 text-default"></i>
                              <span class="nav-link-text">Pembayaran Arisan</span>
                            </a>
                        </li>
                        @endif 
                    </ul>
                    <!-- Divider -->
                    <hr class="my-3">
                </div>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
        
                    </ul>
                    <ul class="navbar-nav align-items-center d-none d-md-flex">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder"
                                            src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg">
                                    </span>
                                    <div class="media-body ml-2 d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>{{ __('My profile') }}</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                    <i class="ni ni-user-run"></i>
                                    <span>{{ __('Logout') }}</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Tables</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Kelompok</li>
                                </ol>
                                @if (session('status'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            @if($errors->any())
		<div class="alert ml-4 mr-4 alert-danger alert-dismissible fade show" role="alert">
  			<strong>Error!</strong> @foreach($errors->all() as $error)
  				<ul>
  					<li>{{ $error }}</li>
  				</ul>
  				@endforeach
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
  				</button>
		</div>
		@endif
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            
                        </div>
                        <!-- Modal Tambah-->
                        {{-- {{$count = Input::get('counter');}} --}}
                        {{-- @foreach($pesertas as $peserta) --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <!-- Dark table -->
            <div class="row">
                <div class="col">
                    <div class="card bg-default shadow">
                        <div class="card-header bg-transparent border-0">
                            <h3 class="text-white mb-0">Kelompok Arisan</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-dark table-flush">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="no">No</th>
                                        <th scope="col" class="sort" data-sort="nama">Nama Kelompok</th>
                                        <th scope="col" class="sort" data-sort="alamat">Keterangan</th>
                                        <th scope="col" class="sort" data-sort="notlp">Harga</th>
                                        <th scope="col" class="sort" data-sort="notlp">Slot</th>
                                        <th scope="col" class="sort" data-sort="notlp">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($kelompok_arisan as $kelompok)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="name mb-0 text-sm">{{++$i}}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="nama">
                                            {{$kelompok->nama_kelompok}}
                                        </td>
                                        <td>
                                            {{$kelompok->keterangan}}
                                        </td>
                                        <td>
                                            {{$kelompok->harga}}
                                        </td>
                                        <td>
                                            {{$kelompok->slot}}
                                        </td>
                                        <td>
                                            {{$kelompok->status}}
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @if($kelompok->status == "Full")
                                                    <button class="btn btn-icon btn-primary dropdown-item"
                                                        ><span class="btn-inner--icon"><i class="ni send"></i></span>
                                                        <span class="btn-inner--text" disabled>Gabung</span></button>
                                                    @else
                                                    {{-- <form action="{{ route('user_arisan.store',$kelompok->id) }}" method="POST"> --}}
                                                        <form action= "/gabung/{{$kelompok->id}}" method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" value={{$pesertas}} name="id_peserta">
                                                        <button class="btn btn-icon btn-success dropdown-item" type="submit">
                                                          <span class="btn-inner--icon"><i class="ni fat-remove"></i></span>
                                                            <span class="btn-inner--text">Gabung</span>
                                                        </button>
                                                      </form>
                                                    @endif
                                                        
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card footer  PAGINASI-->
            <div class="card-footer py-4">
                <nav aria-label="...">
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">
                                <i class="fas fa-angle-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fas fa-angle-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Footer -->
            
        </div>
    </div>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/js-cookie/js.cookie.js"></script>
    <script src="../assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="../assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Argon JS -->
    <script src="../assets/js/argon.js?v=1.2.0"></script>

</body>

</html>
