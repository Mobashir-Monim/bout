<button type="button" class="hidden" id="create-modal-btn" data-toggle="modal" data-target="#create-role-modal">Create</button>
<div class="modal fade" id="create-role-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-modal-title">Create Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="create-modal-body">
                <form action="{{ route('role.create') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 my-2">
                            <input type="text" name="name" class="form-control" placeholder="Role System Name">
                        </div>
                        <div class="col-md-6 my-2">
                            <input type="text" name="display_name" class="form-control" placeholder="Role Display Name">
                        </div>
                        <div class="col-md-4 my-2">
                            <input type="number" step="1" name="limit" class="form-control" placeholder="Role Assignment Limit">
                        </div>
                        <div class="col-md-4 my-2">
                            <select name="is_head" class="form-control">
                                <option value="">Please select Role type</option>
                                <option value="1">Role is for Head/Team Leads</option>
                                <option value="0">Role is for members</option>
                            </select>
                        </div>
                        <div class="col-md-4 my-2">
                            <button class="btn btn-dark w-100" type="submit">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>