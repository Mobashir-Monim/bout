<div class="card border-0 rounded-0">
    <div class="card-header py-1 bg-body rounded-0" id="{{ $part }}-{{ $loop->index }}-heading">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#{{ $part }}-{{ $loop->index }}" aria-expanded="true" aria-controls="{{ $part }}-{{ $loop->index }}">
                {{ $enterprise_part }}
            </button>
        </h2>
    </div>
    <div class="collapse {{ $loop->index == 0 ? 'show' : '' }}" id="{{ $part }}-{{ $loop->index }}" aria-labelledby="{{ $part }}-{{ $loop->index }}-heading" data-parent="#{{ $part }}-accordion">
        <div class="card-body">
            <div class="row">
                @foreach ($segments as $segment_name => $segment)
                    @foreach ($segment as $item)
                        @include('faculty-info.contacts.parts.contact-holder')
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>