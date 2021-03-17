<a class="nav-item container-fluid" href="{{ route('data-backup') }}">
    <li class="nav-link text-white {{ startsWith(request()->url(), route('data-backup')) ? 'active' : '' }}">
        <div class="row">
            <span class="material-icons-outlined pr-1 col-2 my-auto">cloud</span>
            <span class="d-inline-block col-10 my-auto">Data Backup {!! request()->url() == route('data-backup') ? '<span class="sr-only">(current)</span>' : '' !!}</span>
        </div>
    </li>
</a>