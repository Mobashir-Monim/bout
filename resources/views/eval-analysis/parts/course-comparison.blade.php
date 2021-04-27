<div class="row">
    <div class="col-md-6 my-2">
        <div class="card">
            <div class="card-body">
                <canvas id="course-comparison" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 my-2">
        <div class="card">
            <div class="card-body">
                <canvas id="course-distribution" width="400" height="400"></canvas>
                <div class="row">
                    <div class="col-md-8 my-2">
                        <select name="dept" class="form-control" id="dept">
                            <option value="">Please select a Department/School</option>
                            @foreach ($helper->skeleton as $dept => $contents)
                                <option value="{{ $dept }}">{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 my-2">
                        <button class="btn btn-dark w-100" type="button" onclick="getDistribution()">Get Distribution</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('eval-analysis.parts.scripts.courses-distribution')