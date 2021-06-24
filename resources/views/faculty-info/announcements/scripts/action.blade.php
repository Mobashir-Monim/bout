<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script>
<script defer>
    let url = '{{ isset($announcement) ? route('faculty-info.announcements.update', ['announcement' => $announcement->id]) : route('faculty-info.announcements.create') }}';
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'This is the announcement body, please type in the body here.',
            height: 100
        });
        $('.note-editable').css({"height": "250", "background-color": "white"});
        $('.panel-heading').addClass("bg-light border-bottom border-secondary");
        $('.note-recent-color').css({"padding-left": "4px", "padding-right": "4px", "padding-bottom": "2px"});
        @isset($announcement)
            $('#summernote').summernote('code', `{!! $announcement->content !!}`)
        @endif
    });

    const title = document.getElementById('title');
    const semester = document.getElementById('semester');
    const year = document.getElementById('year');
    const validTill = document.getElementById('valid_till');
    const keywordsCont = document.getElementById('keywords-cont');
    const keywordInp = document.getElementById('keyword');
    let announcementTarget = {!! isset($announcement) ? json_encode($announcement->enterprise_parts) : '[]' !!};
    let keywords = {!! isset($announcement) ? json_encode($announcement->keywords) : '[]' !!};
    let keywordCount = {{ isset($announcement) ? sizeof($announcement->keywords) + 1 : 0 }};
    const notEmptyDOMEl = el => el.value != "";
    const notEmptyArray = arr => arr.length != 0;
    const errors = [
        {
            message: 'Please provide a title for the announcement',
            get hasError () { return notEmptyDOMEl(title); }
        },
        {
            message: 'Please select a semester of validity',
            get hasError () { return notEmptyDOMEl(semester); }
        },
        {
            message: 'Please select a year of validity',
            get hasError () { return notEmptyDOMEl(year); }
        },
        {
            message: 'Please select the date until which the announcement is valid',
            get hasError () { return notEmptyDOMEl(validTill); }
        },
        {
            message: 'Please select the target audience (Announcement For) of the announcement',
            get hasError () { return notEmptyArray(announcementTarget); }
        },
        {
            message: 'Please provide at least one keyword for the announcement (this would be used for searching)',
            get hasError () { return notEmptyArray(keywords); }
        }
    ];

    const setAnnouncementTarget = (part) => {
        if (announcementTarget.includes(part)) {
            announcementTarget.splice(announcementTarget.indexOf(part), 1);
        } else {
            announcementTarget.push(part);
        }
    }

    const addKeyword = () => {
        if (keywordInp.value != "") {
            if (!keywords.includes(keywordInp.value)) {
                keywordsCont.innerHTML += `
                    <span class="badge d-inline-block badge-pill badge-secondary pl-3 py-0 pr-0 mb-1" id="keyword-${ keywordCount }">
                        <span class="d-inline-block text-left" id="keyword-${ keywordCount }-val">${ keywordInp.value }</span>

                        <button class="btn btn-sm btn-dark d-inline-block ml-3" type="button" onclick="removeKeyword(${ keywordCount })" style="border-radius: 50%">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                `;
                keywords.push(keywordInp.value);
                keywordCount += 1;
            }

            keywordInp.value = "";
        }
    }

    const removeKeyword = (id) => {
        keywords.splice(keywords.indexOf(document.getElementById(`keyword-${ id }-val`).innerText), 1);
        document.getElementById(`keyword-${ id }`).remove();
    }

    const verifyAnnouncementData = () => {
        for (let e in errors) {
            if (e.hasError) {
                alert(e.message);
                return false;
            }
        }

        return true;
    }

    const postAnnouncement = () => {
        if (verifyAnnouncementData()) {
            fetch(url, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        title: title.value,
                        semester: semester.value,
                        year: year.value,
                        valid_till: validTill.value,
                        announcement_target: announcementTarget,
                        keywords: keywords,
                        content: $('#summernote').summernote('code')

                    })
                }).then(response => {
                    return response.json();
                }).then(data => {
                    console.log(data);

                    if (data.success) {
                        alert(data.message);
                    } else {
                        let errors = ``;
                        console.log(data.errors, 'henlo');
                        for (let e in data.errors) {
                            for (let i in data.errors[e]) {
                                if (typeof(data.errors[e][i]) == 'string') {
                                    errors = `${ errors }${ data.errors[e][i] }\n`;
                                } else {
                                    for (let j in data.errors[e][i]) {
                                        errors = `${ errors }${ data.errors[e][i][j] }\n`;
                                    }
                                }
                            }
                        }

                        alert(errors);
                    }
                }).catch(error => {
                    console.log(error);
                    alert('Whoop! Something went wrong, please refresh the page and try again');
                });
        }
    }
</script>