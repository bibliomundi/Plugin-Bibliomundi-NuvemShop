@component('mail::message')

{{ __('mail.dear') }} {{ $recipientName }}, <br>

{{ __('mail.thanks_for_buying') }}. {{ __('mail.here_is_download_link') }}: <br>

@if (count($downloadLinks))
<ul>
@foreach ($downloadLinks as $link)
<li>
{{ $link }}
</li>
@endforeach
</ul>
@endif

{{ __('mail.best_regards') }}, <br >
{{ config('app.name') }}
@endcomponent