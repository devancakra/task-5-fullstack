@extends('layouts.app')

@section('content')
    @guest
    @else
    <div class="container mt-4 pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1><i class="bi bi-person-rolodex me-1"></i> {{ __('My Profile') }}</h1><hr></div>
                    @if ($msgLogin = Session::get('LoginNotif'))
                        <div class="alert alert-info alert-dismissible fade show m-3 mt-3 md-3" role="alert">
                            <small class="text-muted"><i class="bi bi-info-square-fill me-1"></i>
                                {{ $msgLogin }}
                            </small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($msgUpdProf = Session::get('updateProfileNotif'))
                        <div class="alert alert-success alert-dismissible fade show m-3 mt-3 md-3" role="alert">
                            <small class="text-muted"><i class="bi bi-info-square-fill me-1"></i>
                                {{ $msgUpdProf }}
                            </small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-12 md-3">
                            <div class="col">
                                <div class="card">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <img src="{{ Auth::user()->image }}" class="img-fluid rounded-start img-profile" alt="gambarpengguna" style="height:240px;max-height:auto;width:240px;max-width:auto;">
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <h5 class="card-title"><strong>Informasi Pengguna</strong></h5>
                                                    </div>
                                                    <div class="col-2">
                                                        <a class="nav-link btn btn-sm" data-bs-toggle="modal" data-bs-target="#EditProfile">
                                                        <i class="bi bi-gear-fill"></i></a>
                                                    </div>
                                                </div><hr>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="card-text mt-2">
                                                            <strong><i class="fa-solid fa-people-roof me-1"></i> Nama :</strong><br>
                                                            <span class="text-capitalize">
                                                                @if (Auth::user()->name != null)
                                                                    {{ Auth::user()->name }}
                                                                @else
                                                                    {{ "Data tidak ditemukan" }}
                                                                @endif
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="card-text mt-2">
                                                            <strong><i class="fa-solid fa-briefcase me-1"></i> Pekerjaan :</strong><br>
                                                            <span class="text-capitalize">
                                                                @if (Auth::user()->pekerjaan != null)
                                                                    {{ Auth::user()->pekerjaan }}
                                                                @else
                                                                    {{ "Data tidak ditemukan" }}
                                                                @endif
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row mt-3 pt-2">
                                                    <div class="col-6">
                                                        <p class="card-text mt-2">
                                                            <strong><i class="fa-solid fa-envelope-open-text me-1"></i> Email :</strong><br>
                                                            <span class="text-lowercase">
                                                                @if (Auth::user()->email != null)
                                                                    {{ Auth::user()->email }}
                                                                @else
                                                                    {{ "Data tidak ditemukan" }}
                                                                @endif
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="card-text mt-2">
                                                            <strong><i class="fa-solid fa-house-chimney-user me-1"></i> Tinggal :</strong><br>
                                                            <span class="text-capitalize">
                                                                @if (Auth::user()->tinggal != null)
                                                                    {{ Auth::user()->tinggal }}
                                                                @else
                                                                    {{ "Data tidak ditemukan" }}
                                                                @endif
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>   

    <div class="modal fade modalmenu" id="EditProfile" tabindex="-1" aria-labelledby="EditProfileLabel" aria-hidden="true">
        <div class="modal-dialog" style="min-width:1000px;min-height:500px;align-items:center;">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-light">
                    <h5 class="modal-title"><i class="bi bi-person-bounding-box me-1"></i> Ubah Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-2" action="{{ url('/edit_profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row col-md-12">
                            <div class="col-md-4 mt-4">
                                <label for="prfname" class="col-form-label"><i class="bi bi-person me-1"></i>{{ __('Nama') }}</label>
                                <input type="text" class="form-control mt-2" name="name" id="prfname" value="{{ Auth::user()->name }}" placeholder="Ubah nama..." required>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="prfwork" class="col-form-label"><i class="fa-solid fa-briefcase me-1"></i>{{ __('Pekerjaan') }}</label>
                                <input type="text" class="form-control mt-2" name="pekerjaan" id="prfwork" value="{{ Auth::user()->pekerjaan }}" placeholder="Ubah pekerjaan..." required>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="prfaddress" class="col-form-label"><i class="fa-solid fa-house-chimney-user me-1"></i>{{ __('Tempat Tinggal') }}</label>
                                <input type="text" class="form-control mt-2" name="tinggal" id="prfaddress" value="{{ Auth::user()->tinggal }}" placeholder="Ubah tempat tinggal..." required>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-4 mt-4">
                                <label for="prfemail" class="col-form-label"><i class="bi bi-envelope me-1"></i>{{ __('Email') }}</label>
                                <input type="email" class="form-control mt-2" name="email" id="prfemail" value="{{ Auth::user()->email }}" placeholder="Ubah email..." required>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="prfpassword" class="col-form-label"><i class="bi bi-key me-1"></i>{{ __('Kata Sandi') }}</label>
                                <div class="input-group mb-3">
                                    <button onclick="ShowPassProfile()" class="btn btn-outline-secondary mt-2" type="button">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <input type="password" class="form-control mt-2" name="password" id="prfpassword" placeholder="Ubah kata sandi..." required>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="prfimg" class="col-form-label"><i class="bi bi-card-image me-1"></i>{{ __('Pilih Foto Pengguna') }}</label>
                                <div class="input-group mb-3 mt-2">
                                    <input type="file" class="form-control" name="image" id="prfimg">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12 mt-2">
                                <label for="prfgender" class="col-form-label"><i class="bi bi-gender-ambiguous me-1"></i>{{ __('Pilih Jenis Kelamin Anda') }}</label>
                                <select id="prfgender" name="jenis_kelamin" class="form-select g-3 mb-3" aria-label=".form-select-lg example">
                                    <option value="L" class="text-small" selected>Laki-Laki (L)</option>
                                    <option value="P" class="text-small">Perempuan (P)</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer bg-secondary mt-2">
                            <a type="button" class="btn btn-danger btn-sm btncancel text-light" data-bs-dismiss="modal">
                            <i class="bi bi-person-x me-1"></i> Batal</a>
                            <button type="submit" class="btn btn-primary btn-sm btnacc text-light">
                            <i class="bi bi-person-check me-1"></i> Setuju</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
    @endguest

    <script>
        function ShowPassProfile() {
            var x = document.getElementById("prfpassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection