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
                        Détails d'utilisateur / {{ $user['email'] }}
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
                        <div class="card-body pb-0">
                            <div class="modal-body">
                                <div class="pl-3 pr-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-12">
                                            <img height="150px" class="bg-white p-2" width="150px" id="imgProfile"
                                             @style(['object-fit: cover; border-radius: 100%; border: black 4px dashed'])
                                                src="{{ asset($user['picture_path']) }}" />
                                        </div>
                                        <div class="col-lg-9 col-md-12">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Nom</label>
                                                        <p class="py-1 text-bold text-dark">{{ $user['name'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <p class="py-1 text-bold text-dark">{{ $user['email'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Type</label>
                                                        <p class="py-1 text-bold text-uppercase text-dark">{{ $user['profile'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="activated">Statut</label>
                                                        <p>
                                                            <span @class([
                                                                'py-1 text-bold text-dark w-auto rounded-app px-4 py-2',
                                                                'bg-danger' => !$user['activated'],
                                                                'bg-success' => $user['activated'],
                                                            ])>
                                                                {{ $user['activated'] ? 'COMPTE ACTIF' : 'DESACTIVE' }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Date de création</label>
                                                        <p class="py-1 text-bold text-dark">{{ $user['created_at_fr'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Dernière modification</label>
                                                        <p class="py-1 text-bold text-dark">{{ $user['updated_at_fr'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-right mt-4">
                                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary px-5"
                                            type="submit">Retour</a>
                                        <a href="{{ route('admin.user.edit', $user['id']) }}" class="btn btn-warning px-5"
                                            type="submit">Modifier cet utilisateur</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
