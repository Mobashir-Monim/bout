@extends('layouts.app')

@section('content')
    @foreach ($students as $student)
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
                                            <input type="number" name="student_id" class="form-control" placeholder="Student ID" value="{{ $student->id }}">
                                            <span class="d-block text-right mr-1 text-secondary">Student ID</span>
                                        </div>
                                        <div class="col-md-8 my-1">
                                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $student->name }}">
                                            <span class="d-block text-right mr-1 text-secondary">Name</span>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <textarea name="usis_emails" class="form-control" cols="30" rows="2" placeholder="USIS Email Addresses">{{ $student->usisEmails }}</textarea>
                                            <span class="d-block text-right mr-1 text-secondary">USIS Email Addresses</span>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <textarea name="gsuite" class="form-control" cols="30" rows="2" placeholder="G-suite Address">{{ $student->gsuiteEmail }}</textarea>
                                            <span class="d-block text-right mr-1 text-secondary">G-suite Address</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <input type="text" name="program" class="form-control" placeholder="Program" value="{{ $student->program }}">
                                            <span class="d-block text-right mr-1 text-secondary">Program</span>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <input type="text" name="department" class="form-control" placeholder="Department" value="{{ $student->department }}">
                                            <span class="d-block text-right mr-1 text-secondary">Department</span>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <input type="text" name="school" class="form-control" placeholder="School" value="{{ $student->school }}">
                                            <span class="d-block text-right mr-1 text-secondary">School</span>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <button class="btn btn-dark w-100">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col-md-4 my-3 text-right" style="position: fixed; bottom: 1vh; right: 1vw">
            {{ $students->links() }}
        </div>
    </div>
@endsection