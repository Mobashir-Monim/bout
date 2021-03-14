<button type="button" class="btn btn-dark" id="modal-btn" data-toggle="modal" data-target="#role-modal">Add Enterprise Part</button>
<div class="modal fade" id="role-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Add New Enterprise Part</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <form action="{{ route('enterprise-parts.create') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-8 my-2">
                            <input type="text" name="name" class="form-control" placeholder="Enterprise Part Name">
                        </div>
                        <div class="col-md-4 my-2">
                            <input type="text" name="acronym" class="form-control" placeholder="Enterprise Part Acronym">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 my-2">
                            <input type="email" name="email" class="form-control" placeholder="Enterprise Part Head">
                        </div>
                        <div class="col-md-4 my-2">
                            <select name="is_academic_part" class="form-control">
                                <option value="">Select Part type</option>
                                <option value="1">Academic</option>
                                <option value="0">Non-Academic</option>
                            </select>
                        </div>
                        <div class="col-md-4 my-2">
                            <button class="btn btn-dark w-100" type="submit">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>