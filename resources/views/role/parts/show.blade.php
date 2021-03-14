<button type="button" class="hidden" id="modal-btn" data-toggle="modal" data-target="#role-modal">show modal</button>
<div class="modal fade" id="role-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <h5 class="border-bottom">Viewing Super Admin</h5>
                <div class="row">
                    <div class="col-md mb-1">
                        Name: super-admin
                    </div>
                    <div class="col-md mb-1">
                        Display Name: Super Admin
                    </div>
                </div>
                <div class="row">
                    <div class="col-md mb-1">
                        Limit: 1
                    </div>
                    <div class="col-md mb-1">
                        Assigned: 0
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <h5 class="mb-0 mt-3">Users with Super Admin Role</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mobashir</td>
                                    <td>Monim</td>
                                    <td><a href="#/" class="btn btn-dark" onclick="removeRole('role_id', 'email@address.com')">Remove Role</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>