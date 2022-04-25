<div class="row my-5 hidden" id="tracker-table">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body rounded-0">
                <h5 class="mb-0 text-center" id="tracker-course">Course</h5>
                <div class="row">
                    <div class="col-md-6 my-2">
                        <h6 class="border-bottom"><strong>Theory Evaluation Stats</strong></h6>
                        <span class="border-bottom d-block"><span id="theory-p"><div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div></span>% completed</span>
                        <span class="border-bottom d-block"><span id="theory-c"><div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div></span> evaluated</span>
                        <span class="border-bottom d-block"><span id="theory-r"><div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div></span> unaccounted</span>
                    </div>
                    <div class="col-md-6 my-2">
                        <h6 class="border-bottom"><strong>Lab Evaluation Percentage</strong></h6>
                        <span class="border-bottom d-block"><span id="lab-p"><div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div></span>% completed</span>
                        <span class="border-bottom d-block"><span id="lab-c"><div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div></span> evaluated</span>
                        <span class="border-bottom d-block"><span id="lab-r"><div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div></span> unaccounted</span>
                    </div>
                </div>
                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            {{-- <th scope="col" class="text-center">Theory Eval</th>
                            <th scope="col" class="text-center">Lab Eval</th> --}}
                            <th scope="col" class="text-center">Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="tracker-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>