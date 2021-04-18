<div class="row">
    <div class="col-md-12 my-2">
        <button type="button" class="btn btn-dark" id="modal-btn" data-toggle="modal" data-target="#permission-create-modal"><span class="material-icons-outlined">add</span></button>
    </div>
</div>


<div class="modal fade" id="permission-create-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modal-title">Create Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <form action="{{ route('permissions.create') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 my-2">
                            <input type="text" name="type" class="form-control" placeholder="Permission Type" required>
                        </div>
                        <div class="col-md-6 my-2">
                            <input type="text" name="name" class="form-control" placeholder="Permission Name" required>
                        </div>
                        <div class="col-md-12 my-2">
                            <input type="text" name="title" class="form-control" placeholder="Permission Title" required>
                        </div>
                        <div class="col-md-12 my-2">
                            <textarea name="description" class="form-control" placeholder="Permission Description" required></textarea>
                        </div>
                        <div class="col-md-6 offset-md-6 my-2">
                            <button class="btn btn-dark w-100">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>