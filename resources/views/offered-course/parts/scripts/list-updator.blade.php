<script>
    const updateListItem = (id, type) => {
        fetch("{{ route('offered-courses.list.update') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    id: id,
                    type: type,
                    name: document.getElementById(`${ id }-${ type == 'course' ? 'coordinator' : 'instructor' }-name`).value,
                    email: document.getElementById(`${ id }-${ type == 'course' ? 'coordinator' : 'instructor' }-email`).value,
                    initials: document.getElementById(`${ id }-${ type == 'course' ? 'coordinator' : 'instructor' }-initials`).value,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    if (type == 'course') {
                        updateListView(id)
                    }

                    alert(data.message);
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const updateListView = id => {
        console.log(id)
        let coordinatorInfo = document.getElementById(`${ id }-coordinator-info`);
        console.log(coordinatorInfo);
        coordinatorInfo.innerHTML = `
            ${ document.getElementById(`${ id }-coordinator-name`).value }
            <br>
            ${ document.getElementById(`${ id }-coordinator-email`).value }
        `;
    }

    const copyEvaluation = (destination, type) => {
        fetch("{{ route('offered-courses.list.copy-eval') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    destination: destination,
                    type: type,
                    source: document.getElementById(`${ destination }-${ type == 'course' ? 'offered' : 'section' }-copy`).value,
                })
            }).then(response => {
                console.log(response);
                return response.json();
            }).then(data => {
                console.log(data);
                if (data.success) {
                    alert(data.message);
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }
</script>