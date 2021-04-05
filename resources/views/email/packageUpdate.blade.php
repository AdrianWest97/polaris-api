@component('mail::message')
<h1>Hello {{$name}},</h1>
<br>
<p>{{$message}}</p>
<p>Package #: <b>{{$package_number}}</b>
<br>
Package: <b>{{$description}}</b>
<br/>
Visit <a href='{{env('VUE_APP_URL')}}'>{{env('APP_URL')}}</a> to track your packages.
</p>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
