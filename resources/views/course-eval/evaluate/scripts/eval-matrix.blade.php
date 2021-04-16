<script>
    window.onload = () => {
        setAllMinMaxValsToZero();
        for (const question in questionMatrix) {
            if (!questionMatrix[question].calc.includes('non-eval')) {
                const temp = stripCatVals(questionMatrix[question]);

                if (questionMatrix[question].type.includes('radio')) {
                    radioEval(temp);
                } else {
                    checkBoxEval(temp);
                }
            }
        }

        wFactorAndDiff();
        upadateMinMax();
    }

    const setAllMinMaxValsToZero = () => {
        for (let factor in factorsMatrix) {
            factorsMatrix[factor].diff = 0;
            factorsMatrix[factor].maxVal = 0;
            factorsMatrix[factor].minVal = 0;
        }
    }

    const stripCatVals = (question) => {
        let temp = {};
        Object.keys(question.options).forEach(option => {
            Object.keys(question.options[option]).forEach(cat => {
                if (!temp.hasOwnProperty(cat)) { temp[cat] = []; }
                temp[cat].push(question.options[option][cat]); }) })

        fillEmptySpots(temp);

        Object.keys(temp).forEach(cat => {
            temp[cat].sort((a, b) => { return a - b }); })

        return temp;
    }

    const fillEmptySpots = temp => {
        max = 0;

        for (let c in temp) {
            if (temp[c].length > max) { max = temp[c].length }}

        for (let c in temp) {
            for (let i = max - temp[c].length; i > 0; i--) {
                temp[c].push(0); }}
    }

    const radioEval = temp => {
        Object.keys(temp).forEach(cat => {
            if (cat != 'w') {
                if (temp[cat][temp[cat].length - 1] > 0) {
                    factorsMatrix[cat].maxVal += temp[cat][temp[cat].length - 1];
                } 
        
                factorsMatrix[cat].minVal += temp[cat][0];
            }
        })
    }

    const checkBoxEval = temp => {  
        Object.keys(temp).forEach(cat => {
            if (cat != 'w') {
                let flag = true;
                temp[cat].forEach(val => {
                    if (val > 0) {
                        factorsMatrix[cat].maxVal += val
                    } else {
                        flag = true;
                        factorsMatrix[cat].minVal += val;
                    }
                })

                if (flag) {
                    factorsMatrix[cat].minVal += temp[cat][0];
                }
            }
        })
    }

    const wFactorAndDiff = () => {
        Object.keys(factorsMatrix).forEach(f => {
            factorsMatrix[f].diff = factorsMatrix[f].maxVal - factorsMatrix[f].minVal;
        })
    }

    const upadateMinMax = () => {
        fetch("{{ route('course-eval.factors-config.store-min-max', ['year' => $helper->year, 'semester' => $helper->semester]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    factors: JSON.stringify(factorsMatrix),
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success != true) {
                    throw 'error';
                } else {
                    console.log(data.message)
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Factors min and max vals update failed. Please refresh the page.');
            });
    }

    const factorsMatrix = {!! $helper->eval->factors !!};
    const questionMatrix = {!! json_encode($helper->eval->compiledMatrices) !!};
    const labCourses = {!! json_encode($helper->lab_courses) !!};
</script>