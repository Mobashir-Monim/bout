<table class="table table-dark">
    <tbody>
        <tr>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('1')">1</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('2')">2</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('3')">3</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('+')">+</td>
        </tr>
        <tr>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('4')">4</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('5')">5</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('6')">6</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('-')">-</td>
        </tr>
        <tr>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('7')">7</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('8')">8</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('9')">9</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('*')">*</td>
        </tr>
        <tr>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('.')">.</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('0')">0</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="clearExp()">CLR</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('/')">/</td>
        </tr>
        <tr>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor('(')">(</td>
            <td class="btn btn-sm btn-dark rounded-0 p-1 w-25" onclick="insertFactor(')')">)</td>
        </tr>
        <tr>
            <td colspan="4" class="btn btn-sm btn-dark rounded-0 p-2 w-100" id="active-formula-toggler" onclick="changeActiveFormula()">Lab score formula</td>
        </tr>
    </tbody>
</table>