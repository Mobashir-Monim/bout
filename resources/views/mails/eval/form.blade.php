@component('mail::message')

Dear student,
<br>
Name: <b>{{ $student['name'] }}</b><br>
Student ID: <b>{{ $student['id'] }}</b><br><br>

You have registered for the following courses in the specified Semester:

@component('mail::panel')
@component('mail::table')
| Course Code       | Section             | Semester             |
|:----------------- |:-------------------:| --------------------:|
@foreach ($student['courses'] as $course)
| {{ $course['code'] }}  | {{ $course['section'] }} | {{ $course['semester'] }} |
@endforeach
@endcomponent
@endcomponent

<br><br>

Please fill in the course evaluation(s) for the respective courses by clicking on the respective buttons. <br>
Ignore this email if you have already filled out the evaluations. <br>
<b>You must be logged into your BracU G-suite account to access the evaulation form.</b>

@foreach ($student['courses'] as $course)
@component('mail::button', ['url' => $course['url']])
{{ $course['code'] }}, Section {{ $course['section'] }} Evaluation Link
@endcomponent
@endforeach

<br>

Thanks,<br>
Online Learning Team

<i>This email has been automatically generated on {{ Carbon\Carbon::now()->toDateTimeString() }}</i> <br>
<i>If you think you have received this email by mistake, please ignore it</i>
<i>If the email has been trimmed, please click on the three dots to expand</i> <br>
@endcomponent