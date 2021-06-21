<div class="card my-3">
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-10">
                <h3 class="border-bottom">{{ $announcement->title }}</h3>
            </div>
            <div class="col-md text-right">
                @if (auth()->user()->id == $announcement->user_id || auth()->user()->hasRole('super-admin'))
                    <form action="{{ route('faculty-info.announcements.delete', ['announcement' => $announcement->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('faculty-info.announcements.update', ['announcement' => $announcement->id]) }}" class="btn btn-dark">
                            <span class="material-icons-outlined">edit</span>
                        </a>
                        <button type="submit" class="btn btn-dark">
                            <span class="material-icons-outlined">delete_forever</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
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