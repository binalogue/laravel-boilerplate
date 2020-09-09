@component('mail::layout')
<img src="{{ asset('images/home-hero.png') }}" width="100%" alt="ASICS" style="margin-bottom: 30px;" />

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
