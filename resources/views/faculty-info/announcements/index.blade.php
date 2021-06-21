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

    @include('faculty-info.announcements.parts.floater-buttons')
    @include('faculty-info.announcements.parts.search')
@endsection