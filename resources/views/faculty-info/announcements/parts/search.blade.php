<div class="modal fade show" id="search-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="border-bottom">
                            Search Announcement
                            <button type="button" class="close d-inline-block text-right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </h5>
                        <form action="{{ route('faculty-info.announcements') }}" method="GET">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="search_phrase" class="form-control my-2" placeholder="Search Phrase">
                                    <select name="validity" class="form-control my-2">
                                        <option value="active">Search only active announcements</option>
                                        <option value="archived">Search only archived announcements</option>
                                        <option value="both">Search both valid and expired announcements</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control my-2" name="semester">
                                        <option value="">Please select a semester</option>
                                        @foreach (['Spring', 'Summer', 'Fall'] as $sem)
                                            <option value="{{ $sem }}">{{ $sem }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control my-2" name="year">
                                        <option value="">Please select a year</option>
                                        @for ($i = Carbon\Carbon::now()->diffInYears(Carbon\Carbon::parse('1st Jan 2020')) + 1; $i >= 0; $i--)
                                            <option value="{{ 2020 + $i }}">{{ 2020 + $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4 offset-md-8">
                                    <button class="btn btn-dark w-100">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>