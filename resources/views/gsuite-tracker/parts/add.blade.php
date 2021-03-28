<button type="button" class="btn btn-dark w-100" id="add-modal-btn" data-toggle="modal" data-target="#add-students-modal">Add Students</button>
<div class="modal fade" id="add-students-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-modal-title">Add Student(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="add-modal-body">
                <div class="row">
                    <div class="col-md-8 my-1">
                        <h6 class="border-bottom mb-0">Add multiple student(s)</h6>
                    </div>
                    <div class="col-md-4 my-1">
                        <a href="/sample-files/Mass student upload template.xlsx">Sample File</a>
                    </div>
                    <div class="col-md-8 my-2">
                        <input type="file" name="students-file" class="form-control" accept=".xlsx, .xls, .csv" id="students-file">
                    </div>
                    <div class="col-md-4 my-2" id="mass-upload">
                        <button class="btn btn-dark w-100" type="button" onclick="massUploadStudents()">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('gsuite-tracker.parts.scripts.add')