<script>
    const formatType = document.getElementById('format_type');
    const formatBody = document.getElementById('format_body');
    const savedResponseBody = `
    <div class="col-md-6 text-center my-2">
        <textarea name="saved_response" id="saved_response" class="form-control" style="height: 30vh; resize: none;" placeholder="Please paste the saved response here"></textarea>
        <button class="btn btn-dark w-100 mt-2" onclick="formatJSONToText()">Format saved response</button>
    </div>
    <div class="col-md-6 my-2">
        <textarea name="saved_response_output" id="saved_response_output" class="form-control" style="height: 30vh; resize: none;" placeholder="The formated response will be shown here"></textarea>
        <button class="btn btn-dark w-100 mt-2" onclick="copyCode()">Copy formated output</button>
    </div>
    `;
    const activetableBody = `
    <div class="col-md-6 text-center my-2">
        <textarea name="saved_response" id="table_template" class="form-control" style="height: 30vh; resize: none;" placeholder="Please paste the table template here"></textarea>
    </div>
    <div class="col-md-6 my-2">
        <textarea name="saved_response_output" id="student_answer" class="form-control" style="height: 30vh; resize: none;" placeholder="Please paste the student answer here"></textarea>
    </div>

    <div class="col-md-6 my-2">
        <input type="text" name="default_text" class="form-control" placeholder="Default Text" id="default_text">
    </div>
    <div class="col-md-6 my-2">
        <button class="btn btn-dark w-100" onclick="buildTable()">Build Table</button>
    </div>

    <div class="col-md-12 my-2" id="table_output"></div>
    `;

    const changeFormatType = () => {
        if (formatType.value == 'format_activetable') {
            formatBody.innerHTML = activetableBody;
        } else {
            formatBody.innerHTML = savedResponseBody;
        }
    }

    const formatJSONToText = () => {
        let jsonText = JSON.parse(document.getElementById('saved_response').value);
        document.getElementById('saved_response_output').value = traverseNConcat("", jsonText);
    }

    const traverseNConcat = (str, parts) => {
        if (typeof(parts) != 'string') {
            for (let p in parts) {
                str = `${ str }${ traverseNConcat("", parts[p]) }`;
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

    const buildTable = () => {
        try {
            printTableTemplate();
            replaceWithStudentAnswer();
        } catch (error) {
            alert('Could not build table, please check if the pasted values are correct');
        }
    }

    const printTableTemplate = () => {
        let rows = JSON.parse(formatTemplateTable().replaceAll('\'', '"'));
        let table = `<table class="table table-striped table-dark"><tbody>`;
        
        for (let r in rows) {
            table = `${ table }<tr>`;

            for (let c in rows[r]) {
                table = `${ table }<td id="cell_${ r }_${ c }">${ rows[r][c] }</td>`;
            }

            table = `${ table }</tr>`;
        }

        table = `${ table }</tbody></table>`;
        document.getElementById('table_output').innerHTML = table;
    }

    const formatTemplateTable = () => {
        let tableTemplate = document.getElementById('table_template').value;
        tableTemplate = tableTemplate.replaceAll('\n', '').replaceAll('\t', '').replace(/\s\s+/g, ' ');
        tableTemplate = tableTemplate.replaceAll(document.getElementById('default_text').value, '\'\'');
        tableTemplate = tableTemplate.replace('],]', ']]');

        return tableTemplate;
    }

    const replaceWithStudentAnswer = () => {
        let cells = document.getElementById('student_answer').value;
        cells = JSON.parse(cells.replaceAll('\'', '"'));

        for (let c in cells) {
            document.getElementById(c).innerText = cells[c];
        }
    }
</script>