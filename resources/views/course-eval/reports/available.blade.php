@foreach ($helper->data['reports'] as $dept => $courses)
    <div class="row my-2">
        <div class="col-md-12">
            <h5 class="mb-0">{{ $dept }}</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="py-1">Course</th>
                        <th scope="col" class="py-1 text-center">Section Reports</th>
                        <th scope="col" class="py-1 text-center">Lab Reports</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $code => $course)
                        <tr>
                            <th class="py-1">
                                {{ $code }} ::
                                {{ $course['title'] }}<br>
                                @if (sizeof((array) $course['sections']) > 0)
                                    <a href="{{ $helper->buildRoute($dept, $code) }}">Course Overall Report</a>
                                @endif
                            </th>
                            <td class="py-1 text-center">
                                @if (sizeof((array) $course['sections']) > 0)
                                    @foreach ($course['sections'] as $section)
                                        <a href="{{ $helper->buildRoute($dept, $code, $section) }}" class="d-inline-block m-1">{{ "Section $section" }}</a>
                                    @endforeach
                                @else
                                    No section reports
                                @endif
                            </td>
                            <td class="py-1 text-center">
                                @if (sizeof((array) $course['labs']) > 0)
                                    @foreach ($course['labs'] as $section)
                                        <a href="{{ $helper->buildRoute($dept, $code, $section, true) }}" class="d-inline-block m-1">{{ "Section $section" }}</a>
                                    @endforeach
                                @else
                                    No lab reports
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach