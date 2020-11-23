@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">Dashboard</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('student-map') }}" class="btn btn-dark w-100">buX user to USIS ID map</a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('saved-response-format') }}" class="btn btn-dark w-100">Format saved responses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
