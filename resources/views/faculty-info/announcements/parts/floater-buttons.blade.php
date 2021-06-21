@if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('announcement-author'))
    @if (request()->url() != route('faculty-info.announcements.create'))
        <a href="{{ route('faculty-info.announcements.create') }}" class="btn floater-btn floater-btn-2 btn-dark">
            <span class="material-icons-outlined" style="font-size: 2.2em">add</span>
        </a>
    @endif
    @if (request()->url() != route('faculty-info.announcements.log'))
        <a href="{{ route('faculty-info.announcements.log') }}" class="btn floater-btn floater-btn-3 btn-dark">
            <span class="material-icons-outlined" style="font-size: 2.2em">reorder</span>
        </a>
    @endif
@endif

<button type="button" class="btn floater-btn floater-btn-1 btn-dark" id="search-modal-btn" data-toggle="modal" data-target="#search-modal">
    <span class="material-icons-outlined" style="font-size: 2.2em">search</span>
</button>