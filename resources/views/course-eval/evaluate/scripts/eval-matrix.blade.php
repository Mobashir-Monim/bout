<script>
    window.onload = () => {
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
        // factorsMatrix.w.maxVal = factorsMatrix.w.maxVal.toFixed(2);
        // factorsMatrix.w.minVal = factorsMatrix.w.minVal.toFixed(2);

        Object.keys(factorsMatrix).forEach(f => {
            // if (f != 'w') {
                // factorsMatrix[f].maxVal *= factorsMatrix.w.maxVal;
                
                // if (factorsMatrix[f].minVal > 0) {
                //     factorsMatrix[f].minVal *= factorsMatrix.w.minVal;
                // } else {
                //     factorsMatrix[f].minVal *= factorsMatrix.w.maxVal;
                // }

                factorsMatrix[f].diff = factorsMatrix[f].maxVal - factorsMatrix[f].minVal;
            // }
        })
    }

    const factorsMatrix = {!! $helper->eval->factors !!};
    const questionMatrix = {!! json_encode($helper->eval->compiledMatrices) !!};
    const labCourses = [
        "CSE101", "CSE110", "CSE111", "CSE220", "CSE221", "CSE250", "CSE251", "CSE260", "CSE310",
        "CSE321", "CSE330", "CSE341", "CSE350", "CSE360", "CSE370", "CSE391", "CSE419", "CSE420",
        "CSE421", "CSE422", "CSE423", "CSE430", "CSE460", "CSE461", "CSE471", "CSE474", "CSE490",
        "CSE491", "EEE362"
    ]
</script>