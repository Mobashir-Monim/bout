<script>
    const fetchIndexer = {
        department: 0,
        course: 0,
        section: 0
    };

    const getStats = () => {
        fetch("{{ route('eval-export.stats') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    semester: inputs.semester.value,
                    year: inputs.year.value,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                stats.holders.target.department.value = data.depts.length;
                stats.holders.target.course.value = data.courses.length;
                stats.holders.target.section.value = data.sections.length;
                stats.values.department = data.depts;
                stats.values.course = data.courses;
                stats.values.section = data.sections;
            }).catch(error => {
                alert("Semester not found!!!");
                console.log(error);
            });
    }

    const 
</script>