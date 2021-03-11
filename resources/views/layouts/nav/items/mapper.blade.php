<a class="nav-item container-fluid" href="{{ route('student-map') }}">
    <li class="nav-link text-white {{ request()->url() == route('student-map') ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">share</span>
            <span class="d-inline-block col-10 my-auto">Student Mapper {!! request()->url() == route('student-map') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>