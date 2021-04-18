<div class="row">
    <div class="col-md-12 my-2">
        <table class="table table-dark">
            <tr>
                @foreach ($helper->formulaHelper->factors as $f => $factor)
                    <td class="btn btn-sm btn-dark rounded-0 w-25 p-2" onclick="insertFactor('``{{ $factor['name'] }}``')">{{ $factor['name'] . " ($f)" }}</td>

                    @if ($loop->index + 1 % 4 == 0)
                        </tr>
                        <tr>
                    @endif
                @endforeach
            </tr>
        </table>
    </div>
</div>