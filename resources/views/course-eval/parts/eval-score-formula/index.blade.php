@if (isset($helper))
    @if (!is_null($helper->formulaHelper))
        <div class="row">
            <div class="col-md-12 my-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="border-bottom">Section Score Formula</h5>
                        @include('course-eval.parts.eval-score-formula.enterprise-parts')
                        @include('course-eval.parts.eval-score-formula.viewer')
                        @include('course-eval.parts.eval-score-formula.builder')
                        @include('course-eval.parts.eval-score-formula.factors-info')
                    </div>
                </div>
            </div>
        </div>

        @include('course-eval.parts.eval-score-formula.scripts.index')
        @include('course-eval.parts.eval-score-formula.scripts.builder')
    @endif
@endif