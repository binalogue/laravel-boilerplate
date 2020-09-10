@component('mail::layout')
{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ nova_get_setting('app_name', config('app.name')) }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
