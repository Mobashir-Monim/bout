<script>
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
                stats.values.target.department = data.depts;
                stats.values.target.course = data.courses;
                stats.values.target.section = data.sections;
                callNextAPI();
            }).catch(error => {
                alert("Semester not found!!!");
                console.log(error);
            });
    }

    const callNextAPI = () => {
        if (stats.values.progress.section.length + stats.values.errors.section.length < stats.values.target.section.length) {
            getSectionEval();
            stats.holders.progress.section.value = parseInt(stats.holders.progress.section.value) + 1;
        } else if (stats.values.progress.course.length + stats.values.errors.course.length < stats.values.target.course.length) {
            getCourseEval();
            stats.holders.progress.course.value = parseInt(stats.holders.progress.course.value) + 1;
        } else if (stats.values.progress.department.length + stats.values.errors.department.length < stats.values.target.department.length) {
            getDepartmentEval();
            stats.holders.progress.department.value = parseInt(stats.holders.progress.department.value) + 1;
        } else {
            fetchEvalMetadata();
        }
    }

    const getSectionEval = () => {
        fetch("{{ route('eval-export.section') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    section: stats.values.target.section[stats.values.progress.section.length + stats.values.errors.section.length],
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    stats.values.progress.section.push(data.section);
                } else {
                    stats.values.errors.section.push(stats.values.target.section[stats.holders.progress.section.value]);
                }
                callNextAPI();
            }).catch(error => {
                stats.values.errors.section.push(stats.values.target.section[stats.holders.progress.section.value]);
                callNextAPI();
                console.log(error);
            });
    }

    const getCourseEval = () => {
        fetch("{{ route('eval-export.course') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    course: stats.values.target.course[stats.values.progress.course.length + stats.values.errors.course.length],
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    stats.values.progress.course.push(data.course);
                } else {
                    stats.values.errors.course.push(stats.values.target.course[stats.holders.progress.course.value]);
                }
                callNextAPI();
            }).catch(error => {
                stats.values.errors.course.push(stats.values.target.course[stats.holders.progress.course.value]);
                callNextAPI();
                console.log(error);
            });
    }

    const getDepartmentEval = () => {
        console.log(`call ${stats.values.progress.department.length + stats.values.errors.department.length}`);
        fetch("{{ route('eval-export.department') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    dept: stats.values.target.department[stats.values.progress.department.length + stats.values.errors.department.length],
                    cer_id: `${ inputs.year.value }_${ inputs.semester.value }`
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    stats.values.progress.department.push(data.department);
                } else {
                    console.log(stats.values.target.department[stats.holders.progress.department.value]);
                    stats.values.errors.department.push(stats.values.target.department[stats.holders.progress.department.value]);
                }
                callNextAPI();
            }).catch(error => {
                stats.values.errors.department.push(stats.values.target.department[stats.holders.progress.department.value]);
                callNextAPI();
                console.log(error);
            });
    }

    const fetchEvalMetadata = () => {
        fetch("{{ route('eval-export.metadata') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    run: `${ inputs.year.value }_${ inputs.semester.value }`
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                exportable.sem = inputs.semester.value;
                exportable.year = inputs.year.value;
                exportable.factors = data.factors;
                exportable.matrix = data.matrix;
                formatExportable();
            }).catch(error => {
                console.log(error);
            });
    }

    const callableFunctions = {
        department: getDepartmentEval,
        course: getCourseEval,
        section: getSectionEval
    }
</script>