@if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd' && isset($helper))
    <div class="row">
        <div class="col-md-12 my-2 mt-4">
            <h5 class="border-bottom text-left">Evaluation Configurations</h5>
            <button onclick="configFactors()" type="button" class="btn btn-dark d-inline-block m-1">Factors</button>
            <button onclick="configMatrix()" type="button" class="btn btn-dark d-inline-block m-1">Matrix</button>
            <button onclick="evaluateCourses()" type="button" class="btn btn-dark d-inline-block m-1">Evaluate</button>
            @if ($helper->isPublishable())
                <button type="button" onclick="toggleEvalPublish()" class="btn btn-dark d-inline-block m-1">{{ !$helper->eval->is_published ? 'Publish' : 'Unpublish' }}</button>
            @endif
        </div>
    </div>
    @if ($helper->isPublishable())
        <form action="{{ route('eval-report.publish-toggle', ['year' => $helper->year, 'semester' => $helper->semester]) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="hidden" id="publish-btn">{{ !$helper->eval->is_published ? 'Publish' : 'Unpublish' }}</button>
        </form>
    @endif
@endif