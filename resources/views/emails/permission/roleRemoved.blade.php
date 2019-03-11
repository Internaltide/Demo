@component('mail::message')
# Role Removed

@component('mail::panel')
Certain role has been deleted!

@component('mail::table')
| Datetime       | Deleted Role         | User  |
| -------------------------- |:-------------:| --------:|
@foreach ($logs as $log)
|  {{$log->date}}  {{$log->time}}   | {{ $log->delRole}}     |  {{$log->username}}    |
@endforeach
@endcomponent
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Goto Staff Backend
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent