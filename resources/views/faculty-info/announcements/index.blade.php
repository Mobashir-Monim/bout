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
            <div class="col-md-10">
                @foreach ($announcements as $announcement)
                    <div class="card">
                        <div class="card-body pb-0">
                            <h3 class="border-bottom">{{ $announcement->title }}</h3>
                            {!! $announcement->content !!}
                            <hr>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    {{ Carbon\Carbon::parse($announcement->created_at)->format('d M, Y') }}
                                    ({{ $announcement->run }})
                                    <blockquote class="blockquote">
                                        <footer class="blockquote-footer"><cite title="Source Title">{{ $announcement->author->name }}</cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{ $announcements->links() }}
    @endif

    @if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('announcement-author'))
        <a href="{{ route('faculty-info.announcements.create') }}" class="btn add-btn btn-dark">
            <span class="material-icons-outlined" style="font-size: 2.2em">add</span>
        </a>
    @endif
@endsection