<script src="https://cdn.jsdelivr.net/npm/mathjs@9.3.2/lib/browser/math.min.js"></script>
<script>
    const expressionInput = document.getElementById('score-expression');
    let scopes = {};
    
    const insertFactor = factor => {
        let caretPos = 0;
        if (expressionInput.selectionStart == 0) {
            expressionInput.value = `${ factor }${ expressionInput.value }`
            caretPos = expressionInput.value.length;
        } else {
            let start = expressionInput.value.slice(0, expressionInput.selectionStart);
            caretPos = start.length + factor.length;
            let end = expressionInput.value.slice(expressionInput.selectionStart, expressionInput.value.length);
            expressionInput.value = `${ start }${ factor }${ end }`
        }

        expressionInput.focus();
        expressionInput.setSelectionRange(caretPos, caretPos);
    }

    const verifyFormula = () => {
        scopes = {};
        let exp = verifyFactors();

        if (typeof(exp) != 'boolean') {
            try {
                let unmarkedExp = exp.replaceAll('$', '')
                math.evaluate(unmarkedExp, scopes);
                saveExpression(exp);
            } catch (error) {
                alert('Whoops! Seems like there is an arithmatic error with the formula. Please check the formula');
            }
        }
    }

    const verifyFactors = () => {
        let exp = replaceFactors();

        if (exp.includes('`')) {
            alert('Whoops! Seems like there was some problem in the factors of the formula. Please check the formula');
            
            return false;
        }

        return exp;
    }

    const replaceFactors = () => {
        let exp = expressionInput.value;

        for (let f in factors) {
            if (exp.includes('``' + factors[f].name + '``')) {
                exp = exp.replaceAll('``' + factors[f].name + '``', ` $${ f }$ `);
                scopes[f] = 1;
            }
        }

        return exp.replace(/\s\s+/g, ' ');
    }

    const getIndicesOf = (searchStr, str, caseSensitive = true) => {
        let searchStrLen = searchStr.length;

        if (searchStrLen == 0) {
            return [];
        }

        let startIndex = 0, index, indices = [];
        
        if (!caseSensitive) {
            str = str.toLowerCase();
            searchStr = searchStr.toLowerCase();
        }

        while ((index = str.indexOf(searchStr, startIndex)) > -1) {
            indices.push(index);
            startIndex = index + searchStrLen;
        }

        return indices;
    }

    const clearExp = () => {
        expressionInput.value = '';
    }

    const saveExpression = (exp) => {
        fetch("{{ route('eval.score-expression.store', ['year' => $helper->year, 'semester' => $helper->semester, 'dept' => 'dept']) }}".replace('dept', enterprisePart.value), {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    expression: exp,
                })
            }).then(response => {
                console.log(response);
                return response.json();
            }).then(data => {
                console.log(data);

                if (data.success) {
                    // accessParts[enterprisePart.value].expression = exp;
                }

                alert(data.message);
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }
</script>