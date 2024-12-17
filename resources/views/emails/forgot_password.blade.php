Hello {{ $user->full_name }}, <br>
<br>
Here is your new password: <b>{{ $user->random_password }}</b><br>
Don't lose it!<br>
<br>
Thank You,<br>
{{ config('app.name') }}