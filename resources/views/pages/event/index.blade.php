@extends('base')

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Gestion des Utilisateurs</h2>
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
                            <div class="d-flex align-items-center mb-4">
                                <h4 class="card-title">
                                    Liste des évènements
                                    <span class="text-primary px-3 ml-2 py-4 border-primary">
                                        [ Total : {{ count($events) }} ]
                                    </span>
                                </h4>
                                <div class="ml-auto">
									<button type="button" class="btn btn-primary px-4" data-toggle="modal"
										data-target="#signup-modal" id="toggle_modal">
										Nouvel évènement
									</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Chemin</th>
                                            <th>Nom</th>
                                            <th>Type</th>
                                            <th>Place</th>
                                            <th>Contact</th>
                                            <th>Date de debut</th>
                                            <th>Date de fin</th>
                                            <th>Nombre de personne attendues</th>
                                            <th>Entrée</th>
                                            <th>Prix d'entrée</th>
                                            <th>Promoteur</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="py-0 text-center">
                                                <td class="" style="width: 100px">
                                                    <img src="{{ asset($user['picture_path']) }}"
                                                        style="border-radius: 100%; object-fit: cover; width: 50px; height: 50px;"
                                                        alt="">
                                                </td>
                                                <td class="py-4">{{ $user['name'] }}</td>
                                                <td class="py-4">{{ $user['email'] }}</td>
                                                <td class="py-4" class="text-bold">{{ $user['profile_fr'] }}</td>
                                                <td  @class([
                                                    'py-4 text-bold',
                                                    'text-danger' => !$user['activated'],
                                                    'bg-success text-white' => $user['activated'],
                                                ])>
												{{ $user["activated"] ? 'COMPTE ACTIF' : 'DESACTIVE' }}
                                                </td>
                                                <td class="py-4">{{ $user['created_at_fr'] }}</td>
                                                <td class="" style="max-width: 100px">
                                                    {{-- <button type="button" class="btn text-primary"><i class="fa fa-eye"></i></button> --}}
                                                    <a href="{{ route('admin.user.edit', $user['id']) }}" type="button" class="btn text-warning"><i
                                                            class="fa fa-edit"></i></a>
                                                    <form action="{{ route('admin.user.destroy', $user['id']) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                            <i style="color: red" class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.user.destroy', $user['id']) }}" class="btn">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="signup-modal" class="modal fade show" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog">
                    <div class="modal-content p-2 rounded-app">
                        <div class="modal-body">
                            <div class="text-center mt-2 mb-4">
                                <a href="{{ route('admin.user.index') }}" class="text-success">
                                    <span><img class="mr-2" src="/assets/images/logo-icon.png" alt=""
                                            height="18"><img src="/assets/images/logo-text.png" alt=""
                                            height="18"></span>
                                </a>
                            </div>

                            <form class="pl-3 pr-3" action="/admin/user" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <input class="form-control" name="name" id="name" required="" placeholder=""
                                        value="Test01">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" name="email" id="email" required=""
                                        placeholder="" value="Test01@gmail.com">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Mot de passe</label>
                                    <input class="form-control" name="password" type="password" required=""
                                        id="password" placeholder="" value="azertyazerty">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

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

                                <input type="hidden" value="supervisor" name="profile">

                                <div class="form-group text-center mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Créer</button>
                                </div>

                            </form>

                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
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
