<div class="row my-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center">
                @if (!$helper->trackable())
                    <h5 class="text-center my-5">No tracker found for given semester</h5>
                @else
                    <h5 class="border-bottom">Course Section Trackers</h5>
                    @foreach ($helper->getCourseSections() as $section)
                        <button class="btn btn-dark d-inline-block m-1" onclick="getStudentList(`{{ $section->id }}`)">{{ $section->sectionOf->course->code }} - {{ $section->section }} - {{ $section->is_lab_faculty ? 'Lab' : 'Theory' }} Tracker</button>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>