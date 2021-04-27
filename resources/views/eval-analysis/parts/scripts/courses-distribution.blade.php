<script>
    let courseComparison = new Chart(document.getElementById('course-comparison'), {!! $helper->getChartConfig() !!});
    let courseDist = new Chart(document.getElementById('course-distribution'), {});

    const getDistribution = () => {
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
                    dept: document.getElementById('dept').value,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                courseDist.destroy();
                courseDist = new Chart(document.getElementById('course-distribution'), data.chart_config);
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }
</script>