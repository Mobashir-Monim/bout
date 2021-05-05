<div class="row mt-3 mb-2">
    <div class="col-md-12">
        <h5 class="mb-0 border-bottom">Upload Offered Courses {{ sizeof($helper->courses) > 1 ? "(Department wise)" : "" }}</h5>
    </div>
</div>
<div class="row my-1">
    <div class="col-md-10 my-auto">
        @if (sizeof($helper->courses) > 1)
            <select name="dept" class="form-control" id="upload-dept">
                <option value="">Please select a department</option>
                @foreach ($helper->departments as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        @else
            <p class="mb-1">{{ $helper->departments[0] }}</p>
            <input type="hidden" name="dept" id="upload-dept" value="{{ $helper->departments[0] }}">
        @endif

        <input type="file" name="file" id="file" class="form-control my-1" accept=".xlsx, .xls">
    </div>
    <div class="col-md-2 my-1">
        <button class="btn btn-dark w-100" id="uploader" type="button"><i class="fas fa-upload"></i></button>
    </div>
    <div class="col-md-12 text-right hidden my-auto my-2" id="upload-spinner">
        <p class="mb-0">Uploading Data, please do not close browser/tab. The page will automatically refresh after completion</p>
        <div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>
    </div>

    <div class="col-md-12 my-2" id="error-list"></div>
</div>