<div class="row my-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('it-team.student.emails.update', ['student' => $student->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4 my-1">
                                    <input type="number" name="student_id" class="form-control border-right-0 border-left-0 border-top-0" style="font-size: 0.8em" placeholder="Student ID" value="{{ $student->student_id }}">
                                    <span class="d-block text-right mr-1 text-secondary" style="font-size: 0.8em">Student ID</span>
                                </div>
                                <div class="col-md-8 my-1">
                                    <input type="text" name="name" class="form-control border-right-0 border-left-0 border-top-0" style="font-size: 0.8em" placeholder="Name" value="{{ $student->name }}">
                                    <span class="d-block text-right mr-1 text-secondary" style="font-size: 0.8em">Name</span>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-md-12">
                                    <textarea name="usis_emails" class="form-control border-right-0 border-left-0 border-top-0" style="font-size: 0.8em" cols="30" rows="1" placeholder="USIS Email Addresses">{{ $student->usisEmails }}</textarea>
                                    <span class="d-block text-right mr-1 text-secondary" style="font-size: 0.8em">USIS Email Addresses</span>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-md-12">
                                    <textarea name="gsuite" class="form-control border-right-0 border-left-0 border-top-0" style="font-size: 0.8em" cols="30" rows="1" placeholder="G-suite Address">{{ $student->gsuiteEmails }}</textarea>
                                    <span class="d-block text-right mr-1 text-secondary" style="font-size: 0.8em">G-suite Address</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12 my-1">
                                    <input type="text" name="department" class="form-control border-right-0 border-left-0 border-top-0" style="font-size: 0.8em" placeholder="Department" value="{{ $student->department }}">
                                    <span class="d-block text-right mr-1 text-secondary" style="font-size: 0.8em">Department</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 my-1">
                                    <input type="text" name="school" class="form-control border-right-0 border-left-0 border-top-0" style="font-size: 0.8em" placeholder="School" value="{{ $student->school }}">
                                    <span class="d-block text-right mr-1 text-secondary" style="font-size: 0.8em">School</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 my-1">
                                    <input type="text" name="program" class="form-control border-right-0 border-left-0 border-top-0" style="font-size: 0.8em" placeholder="Program" value="{{ $student->program }}">
                                    <span class="d-block text-right mr-1 text-secondary" style="font-size: 0.8em">Program</span>
                                </div>
                                <div class="col-4 my-1 text-right">
                                    <button class="btn btn-dark">
                                        <span class="material-icons-outlined">save</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>