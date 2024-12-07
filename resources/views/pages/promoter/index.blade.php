@extends('base')

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Gestion des Promoteurs</h2>
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
                                    Liste des promoteurs
                                    <span class="text-primary px-3 ml-2 py-4 border-primary">
                                        [ Total : {{ count($users) }} ]
                                    </span>
                                </h4>
                                <div class="ml-auto">
                                    <button type="button" class="btn btn-primary px-4" data-toggle="modal"
                                        data-target="#signup-modal" id="toggle_modal">
                                        Nouveau promoteur
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Structure</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="text-center">
                                                <td class="py-4">{{ $user['name'] }}</td>
                                                <td class="py-4">{{ $user['email'] }}</td>
                                                <td class="py-4">{{ $user['promoter']['structure'] }}</td>
                                                <td  @class([
                                                    'py-4 text-bold',
                                                    'text-danger' => !$user['activated'],
                                                    'bg-success text-white' => $user['activated'],
                                                ])>
												{{ $user["activated"] ? 'COMPTE ACTIF' : 'DESACTIVE' }}
                                                </td>
                                                <td style="max-width: 100px">
                                                    <a href="{{ route('admin.promoter.show', $user['id']) }}" class="btn text-primary"><i class="fa fa-eye"></i></a>
                                                    <a href="{{ route('admin.promoter.edit', $user['id']) }}"
                                                        class="btn text-warning"><i class="fa fa-edit"></i></a>
                                                    <form action="{{ route('admin.promoter.destroy', $user['id']) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce promoteur ?')">
                                                            <i style="color: red" class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.promoter.destroy', $user['id']) }}"
                                                        class="btn">
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

                            <form class="pl-3 pr-3" action="/admin/promoter" method="POST">
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
                                    <label for="structure">Structure</label>
                                    <input class="form-control" name="promoter.structure" type="text" required=""
                                        id="structure" placeholder="" value="Test01">
                                    @error('promoter.structure')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone_number">Téléphone</label>
                                    <input class="form-control" name="promoter.phone_number" type="text"
                                        required="" id="phone_number" placeholder="" value="002283030303030">
                                    @error('promoter.phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="birth_date">Date de naissance</label>
                                    <input class="form-control" name="promoter.birth_date" type="date" required=""
                                        id="birth_date" placeholder="" value="2024-05-05">
                                    @error('promoter.birth_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sex">Sexe</label>
                                    <select class="form-control" id="sex" name="promoter.sex" required="">
                                        <option value="M" selected>Homme</option>
                                        <option value="F">Femme</option>
                                    </select>
                                    @error('promoter.sex')
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

                                <input type="hidden" value="promoter" name="profile">

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
