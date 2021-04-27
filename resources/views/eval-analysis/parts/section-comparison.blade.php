<div class="row">
    <div class="col-md-6 my-2">
        <div class="card">
            <div class="card-body">
                <canvas id="section-comparison" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 my-2">
        <div class="card">
            <div class="card-body">
                <canvas id="section-distribution" width="400" height="400"></canvas>
                <div class="row">
                    <div class="col-md-8 my-2">
                        <select name="dept" class="form-control" id="dept" onchange="getCourses()">
                            <option value="">Please select a Department/School</option>
                            @foreach ($helper->skeleton as $dept => $contents)
                                <option value="{{ $dept }}">{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <select name="course" class="form-control" id="course"></select>
                    </div>
                    <div class="col-md-4 my-2 offset-md-4">
                        <button class="btn btn-dark w-100" type="button" onclick="getDistribution()">Get Distribution</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('eval-analysis.parts.scripts.sections-distribution')