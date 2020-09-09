@php
$logo = nova_get_setting('logo');

if ($logo) {
    $logo = Str::of($logo)->prepend('storage/');
}

$logo = asset($logo ?: 'images/logo.png');
@endphp

@if ($logo)
<img src="{{ $logo }}" width="100" alt="" />
@endif
