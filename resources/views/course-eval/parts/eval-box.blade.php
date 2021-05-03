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
                        @endif
                    @else
                        <h5>Evaluation Results are not available</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif