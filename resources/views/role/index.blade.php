@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 my-auto">
                            <h4>Viewing Available Roles</h4>
                        </div>
                        <div class="col-md-2 my-auto">
                            <button type="button" class="btn btn-dark w-100" id="create-modal-btn" data-toggle="modal" data-target="#create-role-modal">Create</button>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-md-12 table-responsive" id="role-op">
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
                                            <td class="py-1" id="{{ $role->id }}_name">{{ $role->display_name }}</td>
                                            <td class="py-1" id="{{ $role->id }}_limit">{{ $role->limit }}</td>
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

    @include('role.parts.show')
    @include('role.parts.create')
@endsection

@section('scripts')
    @include('role.scripts.index')
@endsection