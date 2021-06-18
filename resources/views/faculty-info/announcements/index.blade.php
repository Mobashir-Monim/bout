@extends('faculty-info.layouts.app')

@section('faculty-info.content')
    
    @if (count($announcements) == 0)
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4 class="text-center text-secondary border-bottom">No Announcements to show</h4>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                @foreach ($announcements as $announcement)
                    @include('faculty-info.announcements.parts.announcement')
                @endforeach
            </div>
        </div>

        {{ $announcements->links() }}
    @endif

    @if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('announcement-author'))
        <a href="{{ route('faculty-info.announcements.create') }}" class="btn floater-btn floater-btn-2 btn-dark">
            <span class="material-icons-outlined" style="font-size: 2.2em">add</span>
        </a>
        <button type="button" class="btn floater-btn floater-btn-1 btn-dark" id="search-modal-btn" data-toggle="modal" data-target="#search-modal">
            <span class="material-icons-outlined" style="font-size: 2.2em">search</span>
        </button>
        <a href="{{ route('faculty-info.announcements.create') }}" class="btn floater-btn floater-btn-3 btn-dark">
            <span class="material-icons-outlined" style="font-size: 2.2em">reorder</span>
        </a>
    @else
        <button type="button" class="btn floater-btn floater-btn-1 btn-dark" id="search-modal-btn" data-toggle="modal" data-target="#search-modal">
            <span class="material-icons-outlined" style="font-size: 2.2em">search</span>
        </button>
    @endif

    @include('faculty-info.announcements.parts.search')
@endsection