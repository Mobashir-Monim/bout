@extends('layouts.dashboard')


@section('content')
    <form action="{{ route('courses') }}" method="GET">
        <div class="row">
            <div class="col-md-6 my-2">
                <h4 class="border-bottom mb-0">Courses</h4>
            </div>
            <div class="col-md-4">
                {{-- <input type="text" name="provider" class="form-control"> --}}
                <select name="provider" class="form-control">
                    @if (request()->has('provider'))
                        <option value="{{ request()->provider }}">{{ request()->provider }}</option>

                        @foreach ($providers as $provider)
                            @if (request()->provider != $provider)
                                <option value="{{ $provider }}">{{ $provider }}</option>
                            @endif
                        @endforeach
                    @else
                        <option value="">Please select a provider</option>

                        @foreach ($providers as $provider)
                            <option value="{{ $provider }}">{{ $provider }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark w-100">Search</button>
            </div>
        </div>
    </form>

    @foreach ($courses as $course)
        <div class="card my-2">
            <div class="card-body">
                <form action="{{ route('courses.update', ['course' => $course->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="row">
                        <div class="col-md-2 my-1">
                            <input type="text" name="code" class="form-control border-right-0 border-left-0 border-top-0" value="{{ $course->code }}">
                        </div>
                        <div class="col-md-4 my-1">
                            <input type="text" name="title" class="form-control border-right-0 border-left-0 border-top-0" value="{{ $course->title }}">
                        </div>
                        <div class="col-md-5 my-1">
                            <select class="form-control border-right-0 border-left-0 border-top-0" name="provider" id="">
                                <option value="{{ $course->provider }}">{{ $course->provider }}</option>
                                @foreach ($providers as $provider)
                                    @if ($course->provider != $provider)
                                        <option value="{{ $provider }}">{{ $provider }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 my-1">
                            <button class="btn btn-dark w-100"><span class="material-icons-outlined">save</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection