@extends('base')

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Gestion des Décors</h2>
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
                                    Liste des décors
                                    <span class="text-primary px-3 ml-2 py-4 border-primary">
                                        [ Total : {{ count($decors) }} ]
                                    </span>
                                </h4>
                                <div class="ml-auto">
                                    <button type="button" class="btn btn-primary px-4" data-toggle="modal"
                                        data-target="#signup-modal" id="toggle_modal">
                                        Nouveau décor
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Nom</th>
                                            <th>Promoteur</th>
                                            <th>Evénement</th>
                                            <th>Disponibilité (Début)</th>
                                            <th>Disponibilité (Fin)</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($decors as $decor)
                                            <tr class="py-0 text-center">
                                                <td class="" style="width: 100px">{{ $decor['name'] }}</td>
                                                <td class="py-4" class="text-bold">
													{{ $decor['event']['promoter']['user']['name'] }}</td>
													<td class="py-4" class="text-bold">{{ $decor['event']['name'] }}</td>
                                                <td class="py-4">{{ $decor['start_use_fr'] }}</td>
                                                <td class="py-4">{{ $decor['end_use_fr'] }}</td>
                                                <td class="" style="max-width: 100px">
                                                    <a href="{{ route('admin.decor.show', $decor['id']) }}"
                                                        class="btn text-primary"><i class="fa fa-eye"></i></a>
                                                    <a href="{{ route('admin.decor.edit', $decor['id']) }}" type="button"
                                                        class="btn text-warning"><i class="fa fa-edit"></i></a>
                                                    <form action="{{ route('admin.decor.destroy', $decor['id']) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet décor ?')">
                                                            <i style="color: red" class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
													@if ($decor['validation'] != 'rejected')
														<form action="{{ route('admin.decor.change_validation', $decor['id']) }}" method="POST"
															style="display:inline-block;">
															@csrf
															@method('PUT')
															<input type="hidden" name="validation" value="rejected">
															<button type="submit" class="btn"
																onclick="return confirm('Êtes-vous sûr de vouloir rejeter cet événement ?')">
																<i style="color: red" class="fa fa-times"></i>
															</button>
														</form>
													@endif
													@if ($decor['validation'] != 'validated')
														<form action="{{ route('admin.decor.change_validation', $decor['id']) }}" method="POST"
															style="display:inline-block;">
															@csrf
															@method('PUT')
															<input type="hidden" name="validation" value="validated">
															<button type="submit" class="btn"
																onclick="return confirm('Êtes-vous sûr de vouloir valider cet événement ?')">
																<i style="color: green" class="fa fa-check"></i>
															</button>
														</form>
													@endif
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
                                <a href="{{ route('admin.decor.index') }}" class="text-success">
                                    <span><img class="mr-2" src="/assets/images/logo-icon.png" alt=""
                                            height="18"><img src="/assets/images/logo-text.png" alt=""
                                            height="18"></span>
                                </a>
                            </div>

                            <form class="pl-3 pr-3" action="/admin/decor" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="event_id">Evénement</label>
                                    <select class="form-control" id="event_id" name="event_id" required="">
                                        @foreach ($events as $event)
                                            <option value="{{ $event['id'] }}">{{ $event['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('event_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <input class="form-control" name="name" id="name" required="" placeholder=""
                                        value="Decor01">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="start_use">Date de début de disponibilité</label>
                                    <input class="form-control" type="date" name="start_use" id="start_use"
                                        required="" placeholder="" value="2024-01-01">
                                    @error('start_use')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="end_use">Date de fin de disponibilité</label>
                                    <input class="form-control" type="date" name="end_use" id="end_use"
                                        required="" placeholder="" value="2024-01-01">
                                    @error('end_use')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file">Décor</label>
                                    <input class="form-control" type="file" name="file" id="file"
                                        required="" placeholder="" value="2024-01-01">
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

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
