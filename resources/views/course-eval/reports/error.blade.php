@extends('layouts.dashboard')

@section('content')
    <div class="row min-h">
        <div class="col-md"></div>
        <div class="col-md-8 my-auto">
            <div class="card">
                <div class="card-header bg-dark text-white">Whoops!!</div>
                <div class="card-body text-center">
                    {{ $status['message'] }} <br>
                    <p class="mb-0" style="font-size: 2em">😱😱😱</p>
                </div>
            </div>
        </div>
        <div class="col-md"></div>
    </div>
@endsection

@section('scripts')
    
@endsection