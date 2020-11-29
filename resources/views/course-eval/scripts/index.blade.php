<script>
    const confirmSemester = () => {
        fetch("{{ route('course-eval.semester-confirm') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    semester: document.getElementById('semester').value,
                    year: document.getElementById('year').value,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                requestIndex++;
                console.log(data);

                if (requestIndex < parts.length) {
                    seedPart();
                } else {
                    document.getElementById('spinner').style.display = 'none';
                    changeStatus(`Completed seeding ${ requestIndex } parts`);
                }
            }).catch(error => {
                console.log(error.json());
            });
    }

    const configFactors = () => {
        window.location.href = "{{ route('course-eval.factors-config', ['year' => 'year', 'semester' => 'semester']) }}".replace('semester', document.getElementById('semester').value).replace('year', document.getElementById('year').value);
    }
    
    const configMatrix = () => {
        window.location.href = "{{ route('course-eval.matrix-config', ['year' => 'year', 'semester' => 'semester']) }}".replace('semester', document.getElementById('semester').value).replace('year', document.getElementById('year').value)
    }

    const evaluateCourses = () => {
        window.location.href = "{{ route('evaluate', ['year' => 'year', 'semester' => 'semester']) }}".replace('semester', document.getElementById('semester').value).replace('year', document.getElementById('year').value)
    }
</script>