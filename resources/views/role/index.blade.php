@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header bg-dark text-white">Role Operations</div>
                <div class="card-body">
                    <h5 class="border-bottom">Operation Mode</h5>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="btn-group w-100" role="group" aria-label="Basic example">
                                <a href="#/" class="btn btn-dark" onclick="displayCreateMode()">Create Roles</a>
                                <a href="#/" class="btn btn-dark" onclick="displayReadMode()">View Roles</a>
                                <a href="#/" class="btn btn-dark" onclick="displayEditMode()">Edit Roles</a>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-md-12 table-responsive" id="role-op">
                            <h5 class="mb-0">Viewing Available Roles</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Role Name</th>
                                        <th scope="col">Role Limit</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                            <th scope="row" class="py-1">{{ $key + 1 }}</th>
                                            <td class="py-1">{{ $role->display_name }}</td>
                                            <td class="py-1">{{ $role->limit }}</td>
                                            <td class="py-1"><a href="#/" onclick="viewDetails('{{ $role->id }}')">View Role Details</a> <div class="mt-2 spinner-border hidden" role="status" style="width: 0.8rem; height: 0.8rem;" id="spinner-{{ $role->id }}"><span class="sr-only">Loading...</span></div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="hidden" id="modal-btn" data-toggle="modal" data-target="#role-modal">show modal</button>
    <div class="modal fade" id="role-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <h5 class="border-bottom">Viewing Super Admin</h5>
                    <div class="row">
                        <div class="col-md mb-1">
                            Name: super-admin
                        </div>
                        <div class="col-md mb-1">
                            Display Name: Super Admin
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-1">
                            Limit: 1
                        </div>
                        <div class="col-md mb-1">
                            Assigned: 0
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <h5 class="mb-0 mt-3">Users with Super Admin Role</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mobashir</td>
                                        <td>Monim</td>
                                        <td><a href="#/" class="btn btn-dark" onclick="removeRole('role_id', 'email@address.com')">Remove Role</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('role.scripts.index')
@endsection