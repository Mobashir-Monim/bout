@if (auth()->user()->hasRole('super-admin'))
    <div class="row my-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="border-bottom">Existing Trackers</h5>
                    <div class="row">
                        @foreach ($trackers as $tracker)
                            <div class="col-md-4 my-2">
                                <a href="{{ route('eval-tracker.show', ['tracker' => $tracker->id]) }}" class="btn btn-dark w-100">
                                    {{ $tracker->course_evaluation_id }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif