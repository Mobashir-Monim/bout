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
                setTimeout(() => {
                    callNextAPI();
                }, 50);
            }).catch(error => {
                alert("Semester not found!!!");
                console.log(error);
            });
    }

    const incrementProgress = (target) => {
        if (parseInt(stats.holders.progress[target].value) < parseInt(stats.holders.target[target].value)) {
            stats.holders.progress[target].value = parseInt(stats.holders.progress[target].value) + 1;
        }

        setTimeout(() => {
            callNextAPI();
        }, 50);
    }

    const callNextAPI = () => {
        if (parseInt(stats.holders.progress.section.value) < parseInt(stats.holders.target.section.value)) {
            getSectionEval();
        } else if (parseInt(stats.holders.progress.course.value) < parseInt(stats.holders.target.course.value)) {
            getCourseEval();
        } else if (parseInt(stats.holders.progress.department.value) < parseInt(stats.holders.target.department.value)) {
            getDepartmentEval();
        } else {
            alert("Done fetching data");
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
                    section: stats.values.target.section[stats.holders.progress.section.value],
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    stats.values.progress.section.push(data.section);
                } else {
                    stats.values.errors.section.push(stats.values.target.section[stats.holders.progress.section.value]);
                }
                incrementProgress('section');
            }).catch(error => {
                stats.values.errors.section.push(stats.values.target.section[stats.holders.progress.section.value]);
                incrementProgress('section');
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
                    course: stats.values.target.course[stats.holders.progress.course.value],
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    stats.values.progress.course.push(data.course);
                } else {
                    stats.values.errors.course.push(stats.values.target.course[stats.holders.progress.course.value]);
                }
                incrementProgress('course');
            }).catch(error => {
                stats.values.errors.course.push(stats.values.target.course[stats.holders.progress.course.value]);
                incrementProgress('course');
                console.log(error);
            });
    }

    const getDepartmentEval = () => {
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
                    dept: stats.values.target.department[stats.holders.progress.department.value],
                    cer_id: `${ inputs.year.value }_${ inputs.semester.value }`
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    stats.values.progress.department.push(data.department);
                } else {
                    stats.values.errors.department.push(stats.values.target.department[stats.holders.progress.department.value]);
                }
                incrementProgress('department');
            }).catch(error => {
                stats.values.errors.department.push(stats.values.target.department[stats.holders.progress.department.value]);
                incrementProgress('department');
                console.log(error);
            });
    }

    const callableFunctions = {
        department: getDepartmentEval,
        course: getCourseEval,
        section: getSectionEval
    }
</script>