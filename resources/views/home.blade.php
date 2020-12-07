@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">Dashboard</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('student-map') }}" class="btn btn-dark w-100">buX user to USIS ID map</a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('saved-response-format') }}" class="btn btn-dark w-100">Format saved responses</a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('eval') }}" class="btn btn-dark w-100">Evaluations</a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('description-builder') }}" class="btn btn-dark w-100">buX Description Builder</a>
                        </div>
                        @if(auth()->user()->email == 'mobashir.monim@bracu.ac.bd' || auth()->user()->email == 'ext.mobashir.monim@bracu.ac.bd')
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('student-map-seeder') }}" class="btn btn-dark w-100">Init seeder</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('role') }}" class="btn btn-dark w-100">Roles</a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('permissions') }}" class="btn btn-dark w-100">Permissions</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
