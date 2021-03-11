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
                    console.log(response)
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
                                    <a href="#/" onclick="saveRoleChanges('${ roleID }')" class="btn btn-dark w-100">Save Changes</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 my-1">
                                    <input type="email" name="email" id="user-email" class="form-control" placeholder="Email Address to add">
                                </div>
                                <div class="col-md-4 my-1">
                                    <button type="button" class="btn btn-dark w-100" onclick="addUser('${ roleID }')">Add user to role</button>
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
                        console.log('here')
                        alert('Whoops! Something went wrong...');
                    }
                }).catch(error => {
                    console.log(error);
                    alert('Whoops! Something went wrong...');
                });
        }, 100);
    }

    const saveRoleChanges = (roleID) => {
        let name = document.getElementById('role_name').value;
        let display_name = document.getElementById('display').value;
        let limit = document.getElementById('limit').value;
        updateView(display_name, limit, roleID);
        updateBackend(name, display_name, limit, roleID);
    }

    const updateView = (name, limit, roleID) => {
        modalTitle.innerText = `Viewing ${ name }`;
        document.getElementById(`${ roleID }_name`).innerHTML = name;
        document.getElementById(`${ roleID }_limit`).innerHTML = limit;
    }

    const updateBackend = (name, display_name, limit, roleID) => {
        let endpoint = `{{ route('role.update', ['role' => 'replace']) }}`.replace('replace', roleID);

        fetch(`${ endpoint }`, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    name: name,
                    display_name: display_name,
                    limit: limit,
                })
            }).then(response => {
                console.log(response)
                return response.json();
            }).then(data => {
                alert(`Yay! Successfully make changes!`);
            }).catch(error => {
                console.log(error);
                alert(`Whoops! Something went wrong while trying to update. Please try again later.`);
            });
    }

    const addUser = roleID => {
        let endpoint = `{{ route('role.add-user', ['role' => 'replace']) }}`.replace('replace', roleID);

        fetch(`${ endpoint }`, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    email: document.getElementById('user-email').value,
                })
            }).then(response => {
                console.log(response)
                return response.json();
            }).then(data => {
                alert(`${ data.message }`);
            }).catch(error => {
                console.log(error);
                alert(`Whoops! Something went wrong while trying to update. Please try again later.`);
            });
    }
</script>