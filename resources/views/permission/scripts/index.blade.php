<script>
    let permissions = {!! json_encode($permissions->toArray()) !!};
    let currentActive = '';
    const namePanel = document.getElementById('permission-name');
    const desctiptionPanel = document.getElementById('permission-description');
    const detailsPanel = document.getElementById('permission-details');
    
    window.onload = () => {
        setPermissions();
    }

    const setPermissions = () => {
        categorizePermissions();
        let accordion = document.getElementById('permissions-accordion');

        for (let permission in permissions) {
            accordion.innerHTML += `
                <div class="card border-0 rounded-0">
                    <div class="card-header bg-dark text-white p-1" id="${ permission }">
                        <h2 class="mb-0">
                        <button class="btn btn-light btn-block text-left" type="button" data-toggle="collapse" data-target="#${ permission }-group" aria-expanded="true" aria-controls="${ permission }-group">
                            ${ permission.split('-').join(' ').charAt(0).toUpperCase() }${ permission.split('-').join(' ').slice(1) }
                        </button>
                        </h2>
                    </div>
                
                    <div id="${ permission }-group" class="collapse" aria-labelledby="${ permission }" data-parent="#permissions-accordion">
                        <div class="card-body p-2">
                            ${ buildPermissionButtons(permission, permissions[permission]) }
                        </div>
                    </div>
                </div>
            `;
        }
    }

    const categorizePermissions = () => {
        let newPermissions = {};

        for (let permission in permissions) {
            if (!newPermissions.hasOwnProperty(permissions[permission].type)) { newPermissions[permissions[permission].type] = []; }
            newPermissions[permissions[permission].type].push({name: permissions[permission].name, title: permissions[permission].title, id: permissions[permission].id, description: permissions[permission].description, type: permissions[permission].type});
        }

        permissions = newPermissions;
    }

    const buildPermissionButtons = (n, permission) => {
        let buttons = '<div class="list-group">';

        permission.forEach(p => {
            buttons = `${ buttons }<button type="button" class="list-group-item list-group-item-action p-1" onclick="showPermissionDetails('${ n }', '${ p.id }')" id="${ p.id }">${ p.title }</button>`;
        });

        return `${ buttons }</div>`;
    }

    const showPermissionDetails = (p, pid) => {
        if (currentActive != '') { document.getElementById(currentActive).classList.remove('active'); }
        currentActive = pid;
        let c = permissions[p].find(per => per.id == pid);
        document.getElementById(currentActive).classList.add('active');
        desctiptionPanel.innerHTML = c.description;
        namePanel.innerHTML = c.title;
        detailsPanel.innerHTML = `Type: <b>${ c.type }</b>    |    Name: <b>${ c.name }</b>`;
    }
</script>