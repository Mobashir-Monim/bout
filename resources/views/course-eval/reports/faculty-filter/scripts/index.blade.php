<script>
    const filterPhrase = document.getElementById('faculty-filter-search-phrase');
    const filterBody = document.getElementById('faculty-filter-tbody');
    const filterSpinner = document.getElementById('faculty-filter-spinner');

    const fetchReports = () => {
        filterSpinner.classList.remove('hidden');
        filterBody.innerHTML = '';
        fetch("{{ route('eval-report.faculty-filter', ['year' => $helper->year, 'semester' => $helper->semester]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    search_phrase: filterPhrase.value,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                addResults(data.results)
            }).catch(error => {
                console.log(error);
                filterSpinner.classList.add('hidden');
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const addResults = results => {
        let rows = '';

        for (let email in results) {
            rows = `${ rows } <tr><td>${ results[email].name }</td><td>${ email }</td><td>${ buildReportLinks(results[email].reports) }</td></tr>`;
        }

        filterBody.innerHTML = rows;
        filterSpinner.classList.add('hidden');
    }

    const buildReportLinks = reports => {
        let links = '';

        reports.forEach(report => {
            links= `${ links }<a href="${ report.link }" class="d-inline-block m-1" target="_blank">${ report.title }</a>`;
        });

        return links;
    }
</script>