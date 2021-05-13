@foreach ($course_list['courses'] as $course)
    <div class="row">
        <div class="col-md-12 my-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="border-bottom mb-0">{{ $course->code }} : {{ $course->title }}</h5>
                    <p class="mb-3">{{ $course->provider }}</p>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="t-col-40">Coordinator</th>
                                <th scope="col" class="t-col-20">Run</th>
                                <th scope="col" class="t-col-20">Sections</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('offered-course.parts.list-group-item-row')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach

<textarea id="temp-id-holder" class="hidden"></textarea>

@include('offered-course.parts.list-group-item-details')