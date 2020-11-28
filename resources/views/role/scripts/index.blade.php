<script>
    let modalBody = document.getElementById('modal-body');
    let modalBtn = document.getElementById('modal-btn');
    let modalTitle = document.getElementById('modal-title');
    let roles = JSON.parse('{!! json_encode($roles->toArray()) !!}');

    let viewDetails = roleID => {
        let role = roles.find(r => roleID == r.id);
        let spinner = document.getElementById(`spinner-${ roleID }`);
        spinner.classList.remove('hidden');
        setTimeout(() => {
            fetch("{{ route('role-users', ['role' => 'id']) }}".replace('id', roleID))
                .then(response => {
                    return response.json();
                }).then(data => {
                    if (data.success) {
                        let users = data.data.users;
                        modalTitle.innerText = `Viewing ${ role.display_name }`;
                        let content =`
                            <div class="row">
                                <div class="col-md mb-1">
                                    Name: <input class="form-control" name="name" id="role_name" value="${ role.name }" placeholder="Role Name" />
                                </div>
                                <div class="col-md mb-1">
                                    Display Name: <input class="form-control" name="display" id="display" value="${ role.display_name }" placeholder="Display Name" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md mb-1">
                                    Limit: <input class="form-control" name="limit" id="limit" value="${ role.limit }" placeholder="Role Limit" step="1" min="1" />
                                </div>
                                <div class="col-md mb-1 mt-auto">
                                    <a href="#/" onclick="saveRoleChanges(${ roleID })" class="btn btn-dark w-100">Save Changes</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0 mt-3">Users with Super Admin Role</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">SL</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Assigned: ${ users.length }</th>
                                            </tr>
                                        </thead>
                                        <tbody id="role-body">
                            `;

                        for(let i = 0; i < users.length; i++) {
                            content = `
                                ${ content }
                                <tr id="${ roleID }-${ users[i].email }">
                                    <th scope="row">${ i + 1 }</th>
                                    <td>${ users[i].name }</td>
                                    <td>${ users[i].email }</td>
                                    <td><a href="#/" onclick="removeRole('${ roleID }', '${ users[i].email }')">Remove Role</a></td>
                                </tr>
                                `;
                        }

                        content = `
                            ${ content }
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            `;

                        modalBody.innerHTML = content;
                        modalBtn.click();
                        spinner.classList.add('hidden');
                    } else {
                        alert('Whoops! Something went wrong...');
                    }
                }).catch(error => {
                    alert('Whoops! Something went wrong...');
                    console.log(error);
                });
        }, 100);
    }

    const saveRoleChanges = () => {
        
    }
</script>