@extends('layouts.dashboard')

@section('content')
    <style>
        th, td {
            font-size: 0.8em;
        }

        .t-col-40 {
            width: 40% !important;
        }

        .t-col-20 {
            width: 20% !important;
        }
    </style>
    
    <form action="{{ route('offered-courses.list') }}" method="get">
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-4 col-10 my-2">
                <input type="text" name="filter_course" class="form-control" placeholder="Filter by course">
            </div>
            <div class="col-md-2 col-2 my-2">
                <button class="btn btn-dark w-100"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            @include('offered-course.parts.list-group-item')
            {{ $course_list['courses']->links() }}
        </div>
    </div>
@endsection

@section('script')
    
@endsection