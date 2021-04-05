@component('mail::message')
<p>Hello {{$fname}},</p>
<p>Welcome to {{ config('app.name') }}. To continue, save your U.S shipping address and verify your account. </p>
<p>
    <strong>Your US Shipping Address: </strong>
    <ul style="list-style-type: none;padding:0">
        <li>{{$fname.''.$lname}}</li>
        <li>Street: {{$address['address_line']}}</li>
        <li>State: {{$address['state']}}</li>
        <li>City: {{$address['city']}}</li>
        <li>Zip: {{$address['zip_code']}}</li>
    </ul>
    To continue to your account, please click the button below to verify your account.
</p>
  @component('mail::button', ['url' => $url])
  Verify your account
  @endcomponent
 <div style="word-wrap: break-word;font-size:small; max-width:600px">
      If you are having trouble clicking the button above,
      copy and paste this link in your web browser
        <a  href="{{url($url)}}">
            {{$url}}
        </a>
    </div>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
