<script>
    const detailsModalBtn = document.getElementById('details-modal-btn');
    const detailsModalBody = document.getElementById('details-modal-body');
    const detailsModalSpinner = document.getElementById('details-modal-spinner');

    const showDetails = (offeredCourseID, event) => {
        if (event.target.tagName == 'TD' || event.target.tagName == 'TR') {
            detailsModalBody.innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
            detailsModalBtn.click();
            fetchOfferedCourseDetails(offeredCourseID);
        }
    }

    const fetchOfferedCourseDetails = offeredCourseID => {
        fetch("{{ route('offered-courses.details') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    offered_course_id: offeredCourseID,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                detailsModalBody.innerHTML = buildHeaderSection(data.details, true);
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }
</script>