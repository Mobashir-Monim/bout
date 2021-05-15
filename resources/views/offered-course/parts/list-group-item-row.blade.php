@foreach ($course_list['offerings'][$course->id] as $offered_id => $offered)
    <tr id="row-{{ $offered_id }}" onclick="showDetails('{{ $offered_id }}', event)">
        <td class="t-col-40" id="{{ $offered_id }}-coordinator-info">
            {{ $offered['coordinator']['name'] }} <br>
            {{ $offered['coordinator']['email'] }}
        </td>
        <td class="t-col-20">
            {{ $offered['run_id'] }}
        </td>
        <td class="t-col-20">
            @if ($offered['sections'] == 0)
                <button class="btn btn-dark" style="z-index: 100" type="button" onclick="deletePart('{{ $offered_id }}', 'offered')"><span class="material-icons-outlined" style="font-size: 1em">delete</span></button>
            @else
                {{ $offered['sections'] }}
            @endif
        </td>
        {{-- <td class="text-right t-col-20">
            <button class="btn btn-dark" type="button"><span class="material-icons-outlined" style="font-size: 1em">visibility</span></button>
            @if (sizeof($offered['duplicates']) > 0)
                <button class="btn btn-dark" type="button"><span class="material-icons-outlined" style="font-size: 1em">pageview</span></button>
            @endif
            <button class="btn btn-dark" type="button"><span class="material-icons-outlined" style="font-size: 1em">delete</span></button>
        </td> --}}
    </tr>
@endforeach