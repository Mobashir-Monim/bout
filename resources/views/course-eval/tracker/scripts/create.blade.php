<script>
    let count = 1;
    let trackerIds = [0];
    let trackers = [];
    const inputAppends = [
        "dept",
        "theory-response",
        "theory-email",
        "theory-course",
        "theory-section",
        "lab-response",
        "lab-email",
        "lab-course",
        "lab-section",
    ];
    const metaCont = document.getElementById('meta-cont');
    const trackerTemp = `
        <div class="card my-3" id="tracker-TRACKERID">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 ml-auto">
                        <button class="btn btn-dark w-100" type="button" onclick="deleteTracker(0)">Delete Tracker</button>
                    </div>
                    <div class="col-md-12">
                        <select name="dept" id="dept-TRACKERID" class="form-control my-3">
                            <option value="">Department/Institute</option>
                            @foreach ($providers as $provider)
                                <option value="{{ $provider }}">{{ $provider }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="border-bottom my-3">Theory Response Details</h6>
                        <input type="text" id="theory-response-TRACKERID" class="form-control my-1" placeholder="Response Google Sheet">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" id="theory-email-TRACKERID" class="form-control my-1" placeholder="Email Address Header">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="theory-email-range-TRACKERID" class="form-control my-1" placeholder="Email Range">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" id="theory-course-TRACKERID" class="form-control my-1" placeholder="Course Code Header">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="theory-course-range-TRACKERID" class="form-control my-1" placeholder="Code Range">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" id="theory-section-TRACKERID" class="form-control my-1" placeholder="Section Header">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="theory-section-range-TRACKERID" class="form-control my-1" placeholder="Section Range">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="border-bottom my-3">Lab Response Details</h6>
                        <input type="text" id="lab-response-TRACKERID" class="form-control my-1" placeholder="Response Google Sheet">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" id="lab-email-TRACKERID" class="form-control my-1" placeholder="Email Address Header">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="lab-email-range-TRACKERID" class="form-control my-1" placeholder="Email Range">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" id="lab-course-TRACKERID" class="form-control my-1" placeholder="Course Code Header">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="lab-course-range-TRACKERID" class="form-control my-1" placeholder="Code Range">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" id="lab-section-TRACKERID" class="form-control my-1" placeholder="Section Header">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="lab-section-range-TRACKERID" class="form-control my-1" placeholder="Section Range">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    const appendTracker = () => {
        const trackerMeta = trackerTemp.replaceAll("TRACKERID", count);
        metaCont.insertAdjacentHTML('beforeend', trackerMeta);
        // metaCont.innerHTML += trackerMeta;
        trackerIds.push(count);
        count += 1;
    }

    const deleteTracker = id => {
        trackerIds.splice(trackerIds.indexOf(id), 1);
        document.getElementById(`tracker-${ id }`).remove();
    }

    const collateTrackers = () => {
        trackers = [];
        for (let i in trackerIds) {
            trackers.push({
                department: document.getElementById(`dept-${ trackerIds[i] }`).value,
                theory: {
                    sheet: document.getElementById(`theory-response-${ trackerIds[i] }`).value,
                    email: {
                        header: document.getElementById(`theory-email-${ trackerIds[i] }`).value,
                        range: document.getElementById(`theory-email-range-${ trackerIds[i] }`).value,
                    },
                    course: {
                        header: document.getElementById(`theory-course-${ trackerIds[i] }`).value,
                        range: document.getElementById(`theory-course-range-${ trackerIds[i] }`).value,
                    },
                    section: {
                        header: document.getElementById(`theory-section-${ trackerIds[i] }`).value,
                        range: document.getElementById(`theory-section-range-${ trackerIds[i] }`).value,
                    },
                },
                lab: {
                    sheet: document.getElementById(`lab-response-${ trackerIds[i] }`).value,
                    email: {
                        header: document.getElementById(`lab-email-${ trackerIds[i] }`).value,
                        range: document.getElementById(`lab-email-range-${ trackerIds[i] }`).value,
                    },
                    course: {
                        header: document.getElementById(`lab-course-${ trackerIds[i] }`).value,
                        range: document.getElementById(`lab-course-range-${ trackerIds[i] }`).value,
                    },
                    section: {
                        header: document.getElementById(`lab-section-${ trackerIds[i] }`).value,
                        range: document.getElementById(`lab-section-range-${ trackerIds[i] }`).value,
                    },
                }
            });

        }

        checkDuplicateProviders();
    }

    const checkDuplicateProviders = () => {
        const providers = trackers.map(t => t.department).sort().filter((item, pos, arr) => !pos || item != arr[pos - 1]);
        
        if (providers.length < trackers.length) {
            alert(`Duplicate trackers for same department found!!! One department may only have one tracker per semester.`);
        } else {
            if (document.getElementById('semester').value !== "" && document.getElementById('year').value !== "") {
                storeTrackers();
            } else {
                alert(`Please select a tracker semester and year`);
            }
        }
    }

    const storeTrackers = () => {
        document.getElementById('trackers').value = JSON.stringify(trackers);
        document.getElementById('tracker-form').submit();
    }
</script>