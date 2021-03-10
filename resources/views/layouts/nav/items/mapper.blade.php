<a class="nav-item container-fluid" href="{{ route('student-map') }}">
    <li class="nav-link text-white {{ request()->url() == route('student-map') ? 'active' : '' }} row">
        <span class="material-icons-outlined">share</span>
        <span class="d-inline-block col-10 my-auto">Student Mapper {!! request()->url() == route('student-map') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
    </li>
</a>