<a class="nav-item container-fluid" href="{{ route('it-team.student.emails.index') }}">
    <li class="nav-link text-white {{ request()->url() == route('it-team.student.emails.index') ? 'active' : '' }} row">
        <span class="material-icons-outlined">manage_accounts</span>
        <span class="d-inline-block col-10 my-auto">Student G-suite Tracker {!! request()->url() == route('it-team.student.emails.index') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>