<div class="row">
    <div class="col-md-12 my-2 text-center">
        <button type="button" onclick="initiateExport()" class="btn btn-dark w-100" id="export-btn">Export All Students</button>
        <div class="mt-2 spinner-border hidden" id="export-spinner" role="status"><span class="sr-only">Loading...</span></div>
    </div>
</div>

@include('gsuite-tracker.parts.scripts.export')