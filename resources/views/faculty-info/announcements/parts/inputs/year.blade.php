<div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" for="year">Year</label>
    </div>
    <select class="custom-select" id="year">
        @isset($announcement)
            <option value="{{ $announcement->year }}">{{ $announcement->year }}</option>
        @else
            <option value="">Please select a year</option>
        @endisset
        @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('1st Jan 2020')) + 1; $i >= 0; $i--)
            @isset($announcement)
                @if ($announcement->year != $i + 2020)
                    <option value="{{ 2020 + $i }}">{{ 2020 + $i }}</option>
                @endif
            @else
                <option value="{{ 2020 + $i }}">{{ 2020 + $i }}</option>
            @endisset
        @endfor
    </select>
</div>