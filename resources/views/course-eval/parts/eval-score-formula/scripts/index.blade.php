<script>
    const factorShorts = {!! $helper->formulaHelper->factorShorts !!};
    const factors = {!! $helper->eval->factors !!};
    const accessParts = {!! json_encode($helper->formulaHelper->access_list) !!}
    const enterprisePart = document.getElementById('enterprise-part');
    const formulaBuilder = document.getElementById('formula-builder');
    const formulaViewer = document.getElementById('formula-viewer');
    const expressionViewer = document.getElementById('score-expression-viwer');
    const activeFormula = {
        element: document.getElementById('active-formula'),
        toggle_element: document.getElementById('active-formula-toggler'),
        text: {
            theory: 'Theory score formula',
            lab: 'Lab score formula',
        },
        active: 'theory',
    };

    window.onload = () => {
        if (Object.keys(accessParts).length == 1) {
            changeEnterprisePart();
        }
    }

    const changeEnterprisePart = () => {
        if (enterprisePart.value == '') {
            hideSegment(formulaBuilder);
            hideSegment(formulaViewer);
        } else {
            if (accessParts[enterprisePart.value].access_levels.includes("build-formula")) {
                hideSegment(formulaViewer);
                showSegment(formulaBuilder);
                parseExpressionIntoSegment(accessParts[enterprisePart.value].expression[activeFormula.active], expressionInput);
            } else {
                hideSegment(formulaBuilder);
                showSegment(formulaViewer);
                parseExpressionIntoSegment(accessParts[enterprisePart.value].expression[activeFormula.active], expressionViewer);
            }
        }
    }

    const hideSegment = segment => {
        if (!segment.classList.contains('hidden')) {
            segment.classList.add('hidden');
        }
    }

    const showSegment = segment => {
        if (segment.classList.contains('hidden')) {
            segment.classList.remove('hidden');
        }
    }

    const parseExpressionIntoSegment = (exp, segment) => {
        if (exp != null) {
            factorShorts.forEach(f => {
                exp = exp.replaceAll(`$${ f }$`, '``' + factors[f].name + '``');
            });

            segment.value = exp.replace(/\s\s+/g, ' ');
        } else {
            segment.value = exp
        }
    }

    const changeActiveFormula = () => {
        let inactivate = activeFormula.active;
        activeFormula.active = inactivate == 'theory' ? 'lab' : 'theory'
        activeFormula.element.innerText = activeFormula.text[activeFormula.active];
        activeFormula.toggle_element.innerText = activeFormula.text[inactivate];
        changeEnterprisePart();
    }
</script>