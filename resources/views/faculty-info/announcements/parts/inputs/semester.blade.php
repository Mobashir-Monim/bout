<div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" for="semester">Semester</label>
    </div>
    <select class="custom-select" id="semester">
        @isset($announcement)
            <option value="{{ $announcement->semester }}">{{ $announcement->semester }}</option>
        @else
            <option value="">Please select a semester</option>
        @endisset
        @foreach (['Spring', 'Summer', 'Fall'] as $sem)
            @isset($announcement)
                @if ($announcement->semester != $sem)
                    <option value="{{ $sem }}">{{ $sem }}</option>
                @endif
            @else
                <option value="{{ $sem }}">{{ $sem }}</option>
            @endisset
        @endforeach
    </select>
</div>