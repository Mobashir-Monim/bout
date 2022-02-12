<script>
    let downloadModeUpdateStatus = true;
    let downloadable = [];
    let downloadIndex = 0;
    let downloadTableIndex = null;
    let downloadMode = null;
    const downloadSelect = document.getElementById('download-select');
    const downloadModeRow = document.getElementById('download-mode');
    const downloadSpinnerRow = document.getElementById('download-spinner');

    const initiateDownload = () => {
        if (validateDownloadSelect()) {
            toggleDownloadStatusVisual();
            downloadable = {};
            downloadIndex = 0;
            setDownloadTableIndex();
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

    const toggleDownloadStatusVisual = () => {
        if (downloadModeRow.classList.contains('hidden')) {
            downloadModeRow.classList.remove('hidden');
            downloadSpinnerRow.classList.add('hidden');
        } else {
            downloadModeRow.classList.add('hidden');
            downloadSpinnerRow.classList.remove('hidden');
        }
    }

    const setDownloadTableIndex = (findNext = false) => {
        if (downloadMode == 'multi' && findNext) {
            downloadTableIndex += 1;
        } else {
            if (downloadMode == 'multi') {
                downloadTableIndex = 0;
            } else {
                downloadTableIndex = tables.map((e) => e.name).indexOf(downloadSelect.value);
            }
        }
    }

    const updateDownloadMode = () => {
        if (downloadModeUpdateStatus) {
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
        fetch(`{{ route('data-backup.download') }}?page=${ downloadIndex + 1 }`, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    table: tables[downloadTableIndex].name,
                    index: downloadIndex,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                setTableData(data.table_data.data);

                if (data.success) {
                    if (data.has_more) {
                        downloadIndex += 1;
                        downloadTable();
                    } else {
                        makeNextDownloadCall();
                    }
                } else {
                    throw `${ data.message }`;
                }
            }).catch(error => {
                console.log(error);
                console.log(tables[downloadTableIndex].name);
                console.log(downloadIndex);
                toggleDownloadStatusVisual();
                alert(`Whoops! Something went wrong while trying to download. Please try again later.`);
            });
    }

    const setTableData = (tableData) => {
        if (!downloadable.hasOwnProperty(tables[downloadTableIndex].name)) { downloadable[tables[downloadTableIndex].name] = []; }
        downloadable[tables[downloadTableIndex].name] = downloadable[tables[downloadTableIndex].name].concat(tableData);
    }

    const makeNextDownloadCall = () => {
        setDownloadTableIndex(true);
        
        if (downloadMode == 'multi' && downloadTableIndex < tables.length) {
            downloadIndex = 0;
            downloadTable();
        } else {
            downloadModeUpdateStatus = true;
            exportTables(downloadMode == 'multi' ? `db-bout-${ new Date().getTime() }` : `${ tables[downloadTableIndex].name }-${ new Date().getTime() }`);
            toggleDownloadStatusVisual();
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