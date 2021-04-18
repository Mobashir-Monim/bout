<script>
    const factorShorts = {!! $helper->formulaHelper->factorShorts !!};
    const factors = {!! $helper->eval->factors !!};
    const accessParts = {!! json_encode($helper->formulaHelper->access_list) !!}
    const enterprisePart = document.getElementById('enterprise-part');
    const formulaBuilder = document.getElementById('formula-builder');
    const formulaViewer = document.getElementById('formula-viewer');
    const expressionViewer = document.getElementById('score-expression-viwer');

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
                parseExpressionIntoSegment(accessParts[enterprisePart.value].expression, expressionInput);
            } else {
                hideSegment(formulaBuilder);
                showSegment(formulaViewer);
                parseExpressionIntoSegment(accessParts[enterprisePart.value].expression, expressionViewer);
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
</script>