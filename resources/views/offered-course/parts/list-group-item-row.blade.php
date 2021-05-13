@foreach ($course_list['offerings'][$course->id] as $offered_id => $offered)
    <tr id="row-{{ $course->id }}" onclick="showDetails('{{ $offered_id }}')">
        <td class="t-col-40" id="{{ $offered_id }}-coordinator-info">
            {{ $offered['coordinator']['name'] }} <br>
            {{ $offered['coordinator']['email'] }}
        </td>
        <td class="t-col-20">
            {{ $offered['run_id'] }}
        </td>
        <td class="t-col-20">
            {{ $offered['sections'] }}
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