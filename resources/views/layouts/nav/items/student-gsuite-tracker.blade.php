<a class="nav-item container-fluid" href="{{ route('it-team.student.emails.index') }}">
    <li class="nav-link text-white {{ request()->url() == route('it-team.student.emails.index') ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">manage_accounts</span>
            <span class="d-inline-block col-10 my-auto">Student G-suite Tracker {!! request()->url() == route('it-team.student.emails.index') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>

<a class="nav-item container-fluid" href="{{ route('student-admin.enrollment.index') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('student-admin.enrollment.index')) ? 'active' : '' }}">
        <div class="row">
            <span class="pr-1 col-2 my-auto"></span>
            <span class="d-inline-block col-10 my-auto">Enrollments {!! request()->url() == route('student-admin.enrollment.index') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>