<script>
    let sectionComparison = new Chart(document.getElementById('section-comparison'), {!! $helper->getChartConfig() !!});
    let sectionDist = new Chart(document.getElementById('section-distribution'), {});
    let deptCont = document.getElementById('dept');
    let courseCont = document.getElementById('course');
    let skeleton = {!! json_encode($helper->skeleton) !!};

    const getCourses = () => {
        let opts = '<option value="">Select Course</option>';

        if (deptCont.value != "") {
            for (let c in skeleton[deptCont.value]) {
                opts = `${ opts }<option value="${ c }">${ c }</option>`;
            }

            courseCont.innerHTML = opts;
        }
    }

    const validateInputs = () => {
        if (deptCont.value != "") {
            return true;
        } else {
            alert('Please select a department/school first');
        }

        return false;
    }

    const getDistribution = () => {
        if (validateInputs()) {
            fetch("{{ route('eval-analysis.json') }}", {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        chart_type: '{{ $helper->chart_type }}',
                        year: '{{ $helper->year }}',
                        semester: '{{ $helper->semester }}',
                        dist_type: '{{ $helper->dist_type }}',
                        dept: deptCont.value,
                        course: courseCont.value,
                    })
                }).then(response => {
                    return response.json();
                }).then(data => {
                    sectionDist.destroy();
                    data.chart_config.options.plugins.title.text = `${ courseCont.value == "" ? deptCont.value : courseCont.value } sections score distribution`;
                    sectionDist = new Chart(document.getElementById('section-distribution'), data.chart_config);
                }).catch(error => {
                    console.log(error);
                    alert('Whoop! Something went wrong, please refresh the page and try again');
                });
        }
    }
</script>