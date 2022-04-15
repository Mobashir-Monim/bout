<form action="{{ route('eval-tracker.semester-confirm') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <h5 class="border-bottom">Select evaluation semester</h5>
        </div>
        <div class="col-md-5 my-1">
            <select name="semester" id="semester" class="form-control">
                @if (!isset($helper))
                    <option value="">Please select a semester</option>
                    <option value="spring">Spring</option>
                    <option value="summer">Summer</option>
                    <option value="fall">Fall</option>
                @else
                    <option value="{{ $helper->semester }}">{{ ucfirst($helper->semester) }}</option>
                    @foreach (['spring', 'summer', 'fall'] as $item)
                        @if ($helper->semester != $item)
                            <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-5 my-1">
            <select name="year" id="year" class="form-control">
                @if (isset($helper))
                    <option value="{{ $helper->year }}">{{ $helper->year }}</option>
                    @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('1st Jan 2022')); $i >= 0; $i--)
                        @if ($helper->year != $i + 2022)
                            <option value="{{ 2022 + $i }}">{{ 2022 + $i }}</option>
                        @endif
                    @endfor
                @else
                    <option value="">Please select a year</option>
                    @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('1st Jan 2022')); $i >= 0; $i--)
                        <option value="{{ 2022 + $i }}">{{ 2022 + $i }}</option>
                    @endfor
                @endif
            </select>
        </div>
        <div class="col-md-2 my-1">
            <button class="btn btn-dark w-100"><span class="material-icons-outlined" style="font-size: 1.2em">check</span></button>
        </div>
    </div>
</form>

@if (auth()->user()->hasRole('super-admin'))
    <div class="row mt-3">
        <div class="col-md-12">
            <a href="{{ route('eval-tracker.create') }}" class="btn btn-dark">Add Tracker</a>
        </div>
    </div>
@endif