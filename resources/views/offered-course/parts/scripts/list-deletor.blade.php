<script>
    const deletePart = (id, type) => {
        fetch("{{ route('offered-courses.list.delete') }}", {
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
                    redirect: '{{ request()->fullUrl() }}'
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    if (type == 'course') {
                        let course = document.getElementById(`${ id }-course`);
                        course.remove();
                    } else if (type == 'offered') {
                        let offered = document.getElementById(`row-${ id }`);
                        offered.remove();
                    } else {
                        let section = document.getElementById(`${ id }-section`);
                        section.remove();
                    }
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }
</script>