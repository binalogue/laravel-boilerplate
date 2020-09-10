@component('mail::message')

{{-- Greeting --}}
@isset ($greeting)
# {{ $greeting }}

@endisset

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{!! $line !!}

@endforeach

{{-- Message --}}
@isset($message)
@component('mail::panel')
{{ $message }}
@endcomponent
@endisset

{{-- Action Button --}}
@isset ($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@isset ($salutation)
{!! $salutation !!}

@endisset

{{-- Subcopy --}}
@isset ($actionText)
@component('mail::subcopy')
@lang('mail.subcopy', [
    'action_text' => $actionText,
    'action_url' => $actionUrl,
])
@endcomponent
@endisset

@endcomponent
