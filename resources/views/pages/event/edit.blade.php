@extends('base')

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">
                        Modification d'utilisateur / {{ $user['email'] }}
                    </h2>
                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- basic table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="modal-body">
                                <div class="text-center mt-2 mb-4">
                                    <a href="{{ route('admin.user.index') }}" class="text-success">
                                        <span><img class="mr-2" src="/assets/images/logo-icon.png" alt=""
                                                height="18"><img src="/assets/images/logo-text.png" alt=""
                                                height="18"></span>
                                    </a>
                                </div>

                                <form class="pl-3 pr-3" action="{{ route('admin.user.update', $user['id']) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="name">Nom</label>
                                                <input class="form-control" name="name" id="name" required=""
                                                    placeholder="" value="{{ $user['name'] }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input class="form-control" type="email" name="email" id="email"
                                                    required="" placeholder="" value="{{ $user['email'] }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="password">Mot de passe</label>
                                                <input class="form-control" name="password" type="password" id="password"
                                                    placeholder="" value="">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="activated">Statut</label>
                                                <select class="form-control" id="activated" name="activated" required="">
                                                    <option value="1" selected>Actif</option>
                                                    <option value="0">Inactif</option>
                                                </select>
                                                @error('activated')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $user['profile'] }}" name="profile">

                                    <div class="form-group text-right">
                                        <button class="btn btn-warning px-5" type="submit">Modifier</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
