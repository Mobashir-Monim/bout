@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-bottom-2">
                <div class="card-body">
                    <h5 class="text-left border-bottom mb-2">Search Student</h5>
                    <form action="{{ route('it-team.student.search') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 my-1 text-right">
                                <input type="text" name="phrase" class="form-control" placeholder="Search Phrase (name, ID or email)" value="{{ isset($phrase) ? $phrase : "" }}">
                                <span class="d-block mr-1 text-secondary">Search Phrase (name, ID or email)</span>
                            </div>
                            <div class="col-md-4 my-1">
                                <button type="submit" class="btn btn-dark w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="max-height: 55vh; overflow-y: scroll">
                    @foreach ($students as $student)
                        @include('gsuite-tracker.parts.student')
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 my-2">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection