@foreach ($helper->courses as $dept => $deptCourses)
    <div class="row mb-3">
        <div class="col-md-12">
            <h5 class="border-bottom">{{ $dept }}</h5>
            @foreach ($deptCourses as $course => $courseDetails)
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col-md-8">{{ $course }}: {{ $courseDetails['title'] }}</div>
                            <div class="col-md">
                                @if ($courseDetails['is_lab'] || $courseDetails['has_lab'])
                                    @if ($courseDetails['is_lab'])
                                        Lab Course
                                    @else
                                        Theory Course with Lab
                                    @endif
                                @else
                                    Theory Course
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (array_key_exists('sections', $courseDetails))
                            @foreach ($courseDetails['sections'] as $section => $content)
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="row border-bottom mb-2">
                                            <div class="col-md-8"><h5 class="mb-0">Section {{ $section }}</h5></div>
                                        </div>
                                        
                                        @if (array_key_exists('theory', $content))
                                            <div class="row mb-3 border-bottom border-2">
                                                <div class="col-md-2 my-auto"><b>Theory Faculty(s)</b></div>
                                                <div class="col-md-10 border-left">
                                                    <div class="row border-bottom d-none d-md-flex">
                                                        <div class="col-md-5"><b>Name</b></div>
                                                        <div class="col-md-2"><b>Initials</b></div>
                                                        <div class="col-md-5"><b>Email Address</b></div>
                                                    </div>
                                                    @foreach ($content['theory'] as $tFaculty)
                                                        <div class="row border-bottoom">
                                                            <div class="col-md-5">{{ $tFaculty['name'] }}</div>
                                                            <div class="col-md-2">{{ $tFaculty['initials'] }}</div>
                                                            <div class="col-md-5">{{ $tFaculty['email'] }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
        
                                        @if (array_key_exists('lab', $content))
                                            <div class="row mb-3 border-bottom border-2">
                                                <div class="col-md-2 my-auto"><b>Lab Faculty(s)</b></div>
                                                <div class="col-md-10 border-left">
                                                    <div class="row border-bottom">
                                                        <div class="col-md-5"><b>Name</b></div>
                                                        <div class="col-md-2"><b>Initials</b></div>
                                                        <div class="col-md-5"><b>Email Address</b></div>
                                                    </div>
                                                    @foreach ($content['lab'] as $lFaculty)
                                                        <div class="row border-bottom">
                                                            <div class="col-md-5">{{ $lFaculty['name'] }}</div>
                                                            <div class="col-md-2">{{ $lFaculty['initials'] }}</div>
                                                            <div class="col-md-5">{{ $lFaculty['email'] }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            Section Details Not Found
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach