<div class="row mt-3 mb-2">
    <div class="col-md-12">
        <h5 class="mb-0 border-bottom">Download Offered Courses {{ sizeof($helper->courses) > 1 ? "(Department wise)" : "" }}</h5>
    </div>
</div>
<div class="row my-1">
    <div class="col-md-10 my-auto">
        @if (sizeof($helper->courses) > 1)
            <select name="dept" class="form-control" id="download-dept">
                <option value="">Please select a department</option>
                @foreach ($helper->departments as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        @else
            <p class="mb-0">{{ $helper->departments[0] }}</p>
            <input type="hidden" name="dept" id="download-dept" value="{{ $helper->departments[0] }}">
        @endif
    </div>
    <div class="col-md-2 my-1">
        <a href="#/" onclick="downloadExistingData()" id="downloader" class="btn btn-dark w-100"><i class="fas fa-download"></i></a>
    </div>
    <div class="col-md-4 text-right hidden" id="download-spinner">
        <div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>
    </div>
</div>