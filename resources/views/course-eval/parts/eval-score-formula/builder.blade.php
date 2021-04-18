<div class="row hidden" id="formula-builder">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-9">
                <textarea style="font-size: 0.9em" id="score-expression" class="form-control" cols="30" rows="7" placeholder="Please build the score formula here"></textarea>
            </div>
            <div class="col-md-3">
                @include('course-eval.parts.eval-score-formula.num-pad')
            </div>
        </div>

        @include('course-eval.parts.eval-score-formula.factors')
        
        <div class="row">
            <div class="col-md-6 my-2">
                <i><b>Note:</b> In case a factor is not present in the report, the factor will be considered zero (0).</i>
            </div>
            <div class="col-md-6 my-2">
                <button type="button" class="btn btn-dark w-100" onclick="verifyFormula()">Save</button>
            </div>
        </div>
    </div>
</div>