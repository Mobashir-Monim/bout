@if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd' && !isset($helper))
    <form action="{{ route('eval.copy') }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body" id="eval-results">
                        <h5 class="border-bottom">Copy Evaluations</h5>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><span class="material-icons-outlined input-icon">query_stats</span></span>
                                            </div>
                                            <input type="text" name="course" class="form-control" placeholder="Course Like">
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><span class="material-icons-outlined input-icon">source</span></span>
                                            </div>
                                            <input type="text" name="source" class="form-control" placeholder="From">
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><span class="material-icons-outlined input-icon">location_on</span></span>
                                            </div>
                                            <input type="text" name="destination" class="form-control" placeholder="To">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="course_copy">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" disabled value="Copy course evaluations">
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" name="section_copy">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control disabled" disabled value="Copy section evaluations">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-10 my-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="dept_copy">
                                        </div>
                                    </div>
                                    {{-- <input type="text" class="form-control disabled" disabled value="Copy dept evaluations"> --}}
                                    <select name="dept" class="form-control">
                                        <option value="">Select department</option>
                                        @foreach (App\Models\EnterprisePart::where('is_academic_part', true)->get() as $dept)
                                            <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 my-1">
                                <button class="btn btn-dark w-100"><span class="material-icons-outlined" style="font-size: 1.2em">check</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif