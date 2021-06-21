<div class="accordion my-3" id="announcement-{{ $announcement->id }}">
    <div class="card">
      <div class="card-header bg-dark p-0" id="heading-{{ $announcement->id }}">
            <h2 class="mb-0">
                <button class="btn btn-dark w-100 text-left" type="button" data-toggle="collapse" data-target="#announcement-body-{{ $announcement->id }}" aria-expanded="true" aria-controls="announcement-body-{{ $announcement->id }}">
                    {{ $announcement->title }}
                </button>
            </h2>
      </div>
  
        <div id="announcement-body-{{ $announcement->id }}" class="collapse" aria-labelledby="heading-{{ $announcement->id }}" data-parent="#announcement-{{ $announcement->id }}">
            <div class="card-body">
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
    </div>
</div>