<script>
    let adminAlert = true;
    let considerAdminMap = false;
    let current = 0;
    let adminMapped = [];
    let sentMappable;
    let sentObjName;

    const adminMap = (mappable, objName) => {
        returnee = [];
        current = 0;
        adminMapped = [];
        sentMappable = mappable;
        sentObjName = objName;
        adminFetch();
    }

    const adminFetch = () => {
        fetch("{{ route('student-map') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    data: [sentMappable[current]],
                    mapType: mapType.value,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                data = data.data;
                returnee = [...returnee, ...data];
                current += 1;

                if (current < sentMappable.length) {
                    adminFetch();
                } else {
                    completeFetch();
                }
            }).catch(error => {
                console.log(error);
                alert('Whoops! Something went wrong. Please try again')
            });
    }

    const completeFetch = () => {
        for (let fRowNum in fileData) {
            let fRow = fileData[fRowNum];
            let temp = {};

            for (let key in fRow) {
                if (key != sentObjName) {
                    temp[key] = fRow[key];
                } else {
                    temp[key] = fRow[key];
                    temp[mapTypesComplex[mapType.value].to] = returnee.filter(r => { return r[mapTypesComplex[mapType.value].id] == fRow[sentObjName] })[0][mapTypesComplex[mapType.value].to];
                }
            }

            mappedData.push(temp);
        }
        
        let filename = `mapped-${ getFilename(document.getElementById('username_file').value) }`.replace('.csv', '').replace('.xls', '').replace('.xlsx', '');
        document.getElementById('username-output').innerHTML = `<a href="#/" class="text-primary stretched-link" id="downloader" onclick="downloadCrunchedData(fileData, '${ filename }')">${ filename }</a>`;
        changeStatus('username', 'Completed! 💪😎😇✌');
        alert('Completed! 💪😎😇✌');
    }
</script>