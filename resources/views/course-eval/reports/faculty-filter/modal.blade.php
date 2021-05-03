<div class="modal fade" id="faculty-filter-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faculty-filter-modal-title">Filter Reports by Faculty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="faculty-filter-modal-body">
                <div class="row">
                    <div class="col-md-6 my-2">
                        <input type="text" name="faculty-filter-search-phrase" id="faculty-filter-search-phrase" class="form-control" placeholder="Search phrase (name/email address)">
                    </div>
                    <div class="col-md-2 my-2 offset-md-0 offset-10">
                        <button class="btn btn-dark" type="button" onclick="fetchReports()"><span class="material-icons-outlined">search</span></button>
                    </div>
                    <div class="col-md-2 my-2">
                        <div class="mt-2 spinner-border hidden" role="status" id="faculty-filter-spinner"><span class="sr-only">Loading...</span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Available Reports in {{ $helper->year . ' ' . $helper->semester }}</th>
                                </tr>
                            </thead>
                            <tbody id="faculty-filter-tbody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>