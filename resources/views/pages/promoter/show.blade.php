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
                        Détails du promoteur / {{ $promoter['name'] }}</h2>
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
                                            <img height="250px" class="bg-white mx-auto p-2" width="250px" id="imgProfile"
                                                @style(['object-fit: cover; border-radius: 100%; border: black 4px dashed']) src="{{ asset($promoter['picture_path']) }}" />
                                        </div>
                                        <div class="col-lg-9 col-md-12">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Nom</label>
                                                        <p class="py-1 text-bold text-dark">{{ $promoter['name'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <p class="py-1 text-bold text-dark">{{ $promoter['email'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="structure">Structure</label>
                                                        <p class="py-1 text-bold text-dark">
                                                            {{ $promoter['promoter']['structure'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="phone_number">Téléphone</label>
                                                        <p class="py-1 text-bold text-dark">
                                                            {{ $promoter['promoter']['phone_number'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="birth_date">Date de naissance</label>
                                                        <p class="py-1 text-bold text-dark">
                                                            {{ $promoter['promoter']['birth_date'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="sex">Sexe</label>
                                                        <p class="py-1 text-bold text-uppercase text-dark">
															{{ $promoter['promoter']['sex'] == "M" ? "Homme" : "Femme" }}
														</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="activated">Statut</label>
                                                        <p>
                                                            <span @class([
                                                                'py-1 text-bold text-dark w-auto rounded-app px-4 py-2',
                                                                'bg-danger' => !$promoter['activated'],
                                                                'bg-success' => $promoter['activated'],
                                                            ])>
                                                                {{ $promoter['activated'] ? 'COMPTE ACTIF' : 'DESACTIVE' }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Date de création</label>
                                                        <p class="py-1 text-bold text-dark">{{ $promoter['created_at_fr'] }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Dernière modification</label>
                                                        <p class="py-1 text-bold text-dark">
                                                            {{ $promoter['updated_at_fr'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-right mt-4">
                                        <a href="{{ route('admin.promoter.index') }}" class="btn btn-secondary px-5"
                                            type="submit">Retour</a>
                                        <a href="{{ route('admin.promoter.edit', $promoter['id']) }}"
                                            class="btn btn-warning px-5" type="submit">Modifier ce promoteur</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // document.addEventListener("DOMContentLoaded", function () {
        //     var myModal = new bootstrap.Modal(document.getElementById('signup-modal'));
        //     myModal.show();
        // });

        document.addEventListener('DOMContentLoaded', function() {
            if ({{ $errors->any() ? 'true' : 'false' }}) {
                $('#signup-modal').modal('show');
            }
        });
    </script>
@endsection
