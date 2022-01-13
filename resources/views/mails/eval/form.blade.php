@component('mail::message')

Dear student,
<br>
Name: <b>{{ $student['name'] }}</b><br>
Student ID: <b>{{ $student['id'] }}</b><br><br>

Please fill in the course evaluation(s) for the respective courses by clicking on the respective links. <br>
Ignore this email if you have already filled out the evaluations. <br>
<b>You must be logged into your BracU G-suite account to access the evaulation form.</b>

You have registered for the following courses in the specified Semester:

@component('mail::panel')
@component('mail::table')
| Course Code       | Section           | Evaluation Link   |
|:----------------- |:-----------------:|:-----------------:|
@foreach ($student['courses'] as $course)
| {{ $course['code'] }}  | {{ $course['section'] }} | <a href="{{ $course['url'] }}" target="_blank">{{ $course['code'] }} - {{ $course['section'] }} Evaluation Link</a> |
@endforeach
@endcomponent
@endcomponent

<br>

Thanks,<br>
Online Learning Team

<i>If the email has been trimmed, please click on the three dots to expand (generated on {{ Carbon\Carbon::now()->toDateTimeString() }})</i> <br>
<i>If you think you have received this email by mistake, please ignore it</i>
@endcomponent