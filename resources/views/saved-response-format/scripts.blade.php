<script>
    const formatJSONToText = () => {
        let jsonText = JSON.parse(document.getElementById('saved_response').value);
        document.getElementById('saved_response_output').value = traverseNConcat("", jsonText);
    }

    const traverseNConcat = (str, parts) => {
        if (typeof(parts) != 'string') {
            for (let p in parts) {
                str = `${ str }${ traverseNConcat(str, parts[p]) }`;
            }

            return str;
        } else {
            return `${ str }${ parts }`;
        }
    }

    const copyCode = () => {
        $("#saved_response_output").select();
        document.execCommand('copy');
        alert('Formatted text has been copied!');
    }
</script>