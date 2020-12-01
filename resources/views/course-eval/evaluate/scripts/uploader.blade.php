<script>
    let parts = [];
    let startingIndex = 0;

    const segregateParts = () => {
        startingIndex = 0;
        parts = JSON.stringify(evaluationResults).match(/.{1,65000}/g);
    }

    const storeResults = () => {
        fetch("{{ route('course-eval.evaluate.store', ['year' => $helper->year, 'semester' => $helper->semester]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    starting_index: startingIndex,
                    parts: generateParts(),
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                console.log(data);

                if (startingIndex < parts.length) {
                    storeResults();
                } else {
                    window.location.href = "{!! route('eval') . '?year=' . $helper->year . '&semester=' . $helper->semester !!}";
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const generateParts = () => {
        let temp = [], max = 32;

        for (let i = 0; (i + startingIndex) < parts.length && max > 0; i++, max--) {
            temp.push(parts[i + startingIndex]);
        }

        startingIndex += 32;
        
        return temp;
    }
</script>