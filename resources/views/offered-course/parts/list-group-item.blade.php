@foreach ($course_list['courses'] as $course)
    <div class="row" id="{{ $course->id }}-course">
        <div class="col-md-12 my-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="border-bottom mb-0">
                        {{ $course->code }}: {{ $course->title }}
                        @if (sizeof($course_list['offerings'][$course->id]) == 0)
                            <span class="d-inline-block float-right">
                                <button class="btn btn-dark" type="button" onclick="deletePart('{{ $course->id }}', 'course')"><span class="material-icons-outlined" style="font-size: 1em">delete</span></button>
                            </span>
                        @endif
                    </h5>
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