@if (isset($helper))
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" id="eval-results">
                    <h5 class="border-bottom">Evaluation Results</h5>
                    @if ($helper->isReportable() && sizeof($helper->results) != 0)
                        @if ($helper->data['type'] == 'reports')
                            @include('course-eval.reports.available')
                        @else
                            @include('course-eval.reports.filter')
                            <a href="{{ route('eval-analysis') }}" class="btn btn-dark w-100 my-2"><span class="material-icons-outlined">insights</span> Evaluation Analytics</a>
                        @endif
                    @else
                        <h5>Evaluation Results are not available</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif