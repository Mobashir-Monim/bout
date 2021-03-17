<script>
    let modeUpdateStatus = true;
    let downloadable = [];
    let index = 0;
    let tableIndex = null;
    let downloadMode = null;
    const downloadSelect = document.getElementById('download-select')

    const initiateDownload = () => {
        if (validateDownloadSelect()) {
            downloadable = {};
            index = 0;
            setTableIndex();
            downloadTable();
        }
    }

    const validateDownloadSelect = () => {
        if (downloadSelect.value != "") {
            if (downloadSelect.value != 'all' && tables.map((e) => e.name).indexOf(downloadSelect.value) == -1) {
                setTimeout(() => { alert("Please select a valid table to download") }, 10);
            } else {
                return true;
            }
        } else {
            setTimeout(() => { alert("Please select a table to download") }, 10);
            return false;
        }
    }

    const setTableIndex = (findNext = false) => {
        if (downloadMode == 'multi' && findNext) {
            tableIndex += 1;
        } else {
            if (downloadMode == 'multi') {
                tableIndex = 0;
            } else {
                tableIndex = tables.map((e) => e.name).indexOf(downloadSelect.value);
            }
        }
    }

    const updateMode = () => {
        if (modeUpdateStatus) {
            if (downloadSelect.value == "all") {
                downloadMode = 'multi';
            } else if (downloadSelect.value == "") {
                downloadMode = null;
            } else {
                downloadMode = 'single';
            }
        }
    }

    const downloadTable = () => {
        fetch(`{{ route('data-backup.download') }}?page=${ index + 1 }`, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    table: tables[tableIndex].name,
                    index: index,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                setTableData(data.table_data.data);

                if (data.success) {
                    if (data.has_more) {
                        index += 1;
                        downloadTable();
                    } else {
                        makeNextCall();
                    }
                } else {
                    throw `${ data.message }`;
                }
            }).catch(error => {
                console.log(error);
                alert(`Whoops! Something went wrong while trying to download. Please try again later.`);
            });
    }

    const setTableData = (tableData) => {
        if (!downloadable.hasOwnProperty(tables[tableIndex].name)) { downloadable[tables[tableIndex].name] = []; }
        downloadable[tables[tableIndex].name] = downloadable[tables[tableIndex].name].concat(tableData);
    }

    const makeNextCall = () => {
        setTableIndex(true);
        
        if (downloadMode == 'multi' && tableIndex < tables.length) {
            index = 0;
            downloadTable();
        } else {
            modeUpdateStatus = true;
            exportTables(downloadMode == 'multi' ? 'db-bout' : tables[tableIndex].name);
        }
    }

    const exportTables = (name) => {
        let wb = XLSX.utils.book_new();
        
        for (let s in downloadable) {
            let ws = XLSX.utils.json_to_sheet(downloadable[s]);
            XLSX.utils.book_append_sheet(wb, ws, s);
        }

        let wbout = XLSX.write(wb, {bookType:'xlsx', type:'binary'});
        saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), `${ name }.xlsx`);
    }

    const s2ab = s => {
        let buf = new ArrayBuffer(s.length);
        let view = new Uint8Array(buf);
        for (let i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
</script>