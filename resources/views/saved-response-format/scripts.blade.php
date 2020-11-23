<script>
    const formatJSONToText = () => {
        let jsonText = JSON.parse(document.getElementById('saved_response').value);
        document.getElementById('saved_response_output').value = traverseNConcat("", jsonText);
    }

    const copyCode = () => {
        $("#saved_response_output").select();
        document.execCommand('copy');
        alert('Formatted text has been copied!');
    }
</script>