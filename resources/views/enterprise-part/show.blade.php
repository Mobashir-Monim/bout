@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="border-bottom border-primary">{{ $part->name }}</h5>
                    <div class="row my-2">
                        <div class="col-md-8">
                            <form action="{{ route('enterprise-parts.update', ['part' => $part->id]) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 my-2">
                                        <input type="text" name="name" {!! !$is_super_admin ? 'class="form-control disabled" disabled' : 'class="form-control"' !!} value="{{ $part->name }}" placeholder="Enterprise Part Name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        <input type="text" name="acronym" value="{{ $part->acronym }}" {!! !$is_super_admin ? 'class="form-control disabled" disabled' : 'class="form-control"' !!} placeholder="Enterprise Part Acronym">
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <button {!! !$is_super_admin ? 'class="btn btn-dark w-100 disabled" disabled' : 'class="btn btn-dark w-100"' !!}>Save</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row my-2">
                                <div class="col-md-12">
                                    <h6 class="border-bottom mb-0"><b>Head</b></h6>
                                    {{ $part->head->name }} [{{ $part->head->email }}]
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-md-12">
                                    <h6 class="border-bottom mb-0"><b>DCO:</b></h6>
                                </div>
                                <div class="col-md-12">
                                    @foreach ($dcos as $dco)
                                        <div class="row">
                                            <div class="col-md-8 my-1">
                                                {{ $dco->name }} [{{ $dco->email }}]
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
        
                            <div class="row my-2">
                                <div class="col-md-12">
                                    <h6 class="border-bottom mb-0"><b>Members</b></h6>
                                </div>
                                <div class="col-md-12">
                                    <div class="card border-bottom border-primary" style="max-height: 20vh; overflow-y: scroll;">
                                        <div class="card-body pt-0">
                                            @foreach ($members as $member)
                                                <div class="row border-bottom">
                                                    <div class="col-md-6 my-1">
                                                        {{ $member->name }}
                                                    </div>
                                                    <div class="col-md-6 my-1">
                                                        <b>[{{ $member->email }}]</b>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-md-12">
                                    <h6 class="border-bottom mb-0"><b>Children</b></h6>
                                </div>
                                <div class="col-md-12">
                                    <div class="card border-bottom border-primary" style="max-height: 20vh; overflow-y: scroll;">
                                        <div class="card-body pt-0">
                                            @foreach ($part->children as $child)
                                                <div class="row border-bottom">
                                                    <div class="col-md-10 my-1">
                                                        {{ $child->name }}
                                                    </div>
                                                    <div class="col-md-2 my-1">
                                                        <b>[{{ $child->acronym }}]</b>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="border-bottom border-primary mb-0">Change Head</h6>
                                    <form action="{{ route('enterprise-parts.change-head', ['part' => $part->id]) }}" method="POST">
                                        @csrf
        
                                        <div class="row">
                                            <div class="col-md-10 my-1">
                                                <input type="email" name="email" id="email" {!! !$is_super_admin ? 'class="form-control disabled" disabled' : 'class="form-control"' !!} placeholder="Email Address of new head">
                                            </div>
                                            <div class="col-md-2 my-1">
                                                <button {!! !$is_super_admin ? 'class="btn btn-dark w-100 disabled" disabled' : 'class="btn btn-dark w-100"' !!}><i class="fas fa-check"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
        
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6 class="border-bottom border-primary mb-0">Change DCO</h6>
                                    <form action="{{ route('enterprise-parts.change-dco', ['part' => $part->id]) }}" method="POST">
                                        @csrf
        
                                        <div class="row">
                                            <div class="col-md-10 my-1">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <select name="mode" {!! !$is_super_admin ? 'class="form-control rounded-0 disabled" disabled' : 'class="form-control rounded-0"' !!} style="border-top-left-radius: 0.25rem !important;border-bottom-left-radius: 0.25rem !important;">
                                                            <option value="1">Add</option>
                                                            <option value="0">Remove</option>
                                                        </select>
                                                    </div>
                                                    <input type="email" name="email" id="email" {!! !$is_super_admin ? 'class="form-control disabled" disabled' : 'class="form-control"' !!} placeholder="Email Address of DCO">
                                                </div>
                                            </div>
                                            <div class="col-md-2 my-1">
                                                <button {!! !$is_super_admin ? 'class="btn btn-dark w-100 disabled" disabled' : 'class="btn btn-dark w-100"' !!}><i class="fas fa-check"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
        
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h6 class="border-bottom border-primary mb-0">Change Members</h6>
                                    <form action="{{ route('enterprise-parts.change-member', ['part' => $part->id]) }}" method="POST">
                                        @csrf
        
                                        <div class="row">
                                            <div class="col-md-10 my-1">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <select name="mode" class="form-control rounded-0" style="border-top-left-radius: 0.25rem !important;border-bottom-left-radius: 0.25rem !important;">
                                                            <option value="1">Add</option>
                                                            <option value="0">Remove</option>
                                                        </select>
                                                    </div>
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address of member">
                                                </div>
                                            </div>
                                            <div class="col-md-2 my-1">
                                                <button class="btn btn-dark w-100"><i class="fas fa-check"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h6 class="border-bottom border-primary mb-0">Change Children</h6>
                                    <form action="{{ route('enterprise-parts.change-children', ['part' => $part->id]) }}" method="POST">
                                        @csrf
        
                                        <div class="row">
                                            <div class="col-md-10 my-1">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <select name="mode" {!! !$is_super_admin ? 'class="form-control rounded-0 disabled" disabled' : 'class="form-control rounded-0"' !!} style="border-top-left-radius: 0.25rem !important;border-bottom-left-radius: 0.25rem !important;">
                                                            <option value="1">Add</option>
                                                            <option value="0">Remove</option>
                                                        </select>
                                                    </div>
                                                    <select name="child" {!! !$is_super_admin ? 'class="form-control disabled" disabled' : 'class="form-control"' !!}>
                                                        <option value="">Select a child to add or remove</option>
                                                        @foreach (App\Models\EnterprisePart::all() as $epart)
                                                            @if ($epart->id != $part->id)
                                                                <option value="{{ $epart->id }}">{{  "$epart->name ($epart->acronym)" }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 my-1">
                                                <button {!! !$is_super_admin ? 'class="btn btn-dark w-100 disabled" disabled' : 'class="btn btn-dark w-100"' !!}><i class="fas fa-check"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('enterprise-parts.change-type', ['part' => $part->id]) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 my-2">
                                        <select name="type" {!! !$is_super_admin ? 'class="form-control disabled" disabled' : 'class="form-control"' !!}>
                                            @if ($part->is_academic_part)
                                                <option value="1">Academic</option>
                                                <option value="0">Non academic</option>
                                            @else
                                                <option value="0">Non academic</option>
                                                <option value="1">Academic</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <button {!! !$is_super_admin ? 'class="btn btn-dark w-100 disabled" disabled' : 'class="btn btn-dark w-100"' !!}><i class="fas fa-check"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection