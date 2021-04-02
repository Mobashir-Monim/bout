@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-white">Permissions</div>
                <div class="card-body p-0">
                    <div class="accordion rounded-0" id="permissions-accordion">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-header bg-dark text-white">Selected Permission Details</div>
                <div class="card-body">
                    <h5 id="permission-name">Please select a permission to view its details</h5>
                    <p id="permission-description" class="mb-1"></p>
                    <p id="permission-details" class="mb-0"></p>
                </div>
            </div>

            <form action="{{ route('permissions.add') }}" method="POST">
                @csrf
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">Add Permissions to users</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 my-1">
                                        <p class="mb-0">Permission Type</p>
                                        <input type="text" name="type" id="permission-type-inp" class="form-control" placeholder="Permission Type" required>
                                    </div>
                                    <div class="col-md-6 my-1">
                                        <p class="mb-0">Permission Name</p>
                                        <input type="text" name="name" id="permission-name-inp" class="form-control" placeholder="Permission Name" required>
                                    </div>
                                    <div class="col-md-12 my-1">
                                        <p class="mb-0">Users</p>
                                        <textarea name="users" class="form-control" placeholder="Comma seperated user emails" required></textarea>
                                    </div>
                                    <div class="col-md-12 my-1">
                                        <p class="mb-0">Enterprise Parts</p>
                                        <div class="row">
                                            @foreach (App\Models\EnterprisePart::all() as $ep)
                                                <div class="col-md-6 my-2">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <input type="checkbox" name="eps[]" value="{{ $ep->id }}">
                                                            </div>
                                                        </div>
                                                        @if (is_null($ep->acronym))
                                                            <input type="text" class="form-control disabled" disabled value="{{ ucwords(strtolower($ep->name)) }}">
                                                        @else
                                                            <input type="text" class="form-control disabled" disabled value="{{ $ep->acronym }} - {{ ucwords(strtolower($ep->name)) }}">
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-1">
                                        <button class="btn btn-dark w-100" type="submit">Add Permissions</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @include('permission.scripts.index')
@endsection