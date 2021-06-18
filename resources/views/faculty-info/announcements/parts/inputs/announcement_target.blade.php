<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Announcement For
</button>
<div class="dropdown-menu" style="min-width: 30vw; max-width: 80vw; max-height: 30vh; overflow: scroll">
    @if (auth()->user()->hasRole('super-admin'))
        <div class="input-group px-1">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" id="ep-null" name="all" onclick="setAnnouncementTarget(null)" {{ isset($announcement) ? (in_array(null, $announcement->enterprise_parts) ? 'checked' : '') : '' }}>
                </div>
            </div>
            <input type="text" class="form-control disabled" disabled value="Everyone" style="font-size: 0.8em">
        </div>
        <div class="dropdown-divider"></div>
        @foreach (App\Models\EnterprisePart::all() as $ep)
            <div class="input-group mb-1 px-1">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="ep-{{ $ep->id }}" onclick="setAnnouncementTarget({{ $ep->id }})" {{ isset($announcement) ? (in_array($ep->id, $announcement->enterprise_parts) ? 'checked' : '') : '' }}>
                    </div>
                </div>
                <input type="text" class="form-control disabled" disabled value="({{ $ep->acronym }}) {{ $ep->name }}" style="font-size: 0.8em">
            </div>
        @endforeach
    @else
        @foreach (App\Models\EnterprisePart::whereIn('id', auth()->user()->hasRole('announcement-author%'))->get() as $ep)
            <div class="input-group mb-1 px-1">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="ep-{{ $ep->id }}" onclick="setAnnouncementTarget({{ $ep->id }})"  {{ isset($announcement) ? (in_array($ep->id, $announcement->enterprise_parts) ? 'checked' : '') : '' }}>
                    </div>
                </div>
                <input type="text" class="form-control disabled" disabled value="({{ $ep->acronym }}) {{ $ep->name }}" style="font-size: 0.8em">
            </div>
        @endforeach
    @endif
</div>