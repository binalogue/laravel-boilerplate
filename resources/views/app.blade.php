<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--
|------------------------------------------------------------------------------
| SEO
|------------------------------------------------------------------------------
|
| See:
|   - [artesaos/seotools](https://github.com/artesaos/seotools)
|
-->

@include('modules.seo')

<!--
|------------------------------------------------------------------------------
| Icons
|------------------------------------------------------------------------------
|
| See:
|   - [RealFaviconGenerator/cli-real-favicon](https://github.com/RealFaviconGenerator/cli-real-favicon)
|
-->

@include('modules.icons')

<!--
|------------------------------------------------------------------------------
| Performance: Preload
|------------------------------------------------------------------------------
|
| See:
|   - [riverskies/laravel-mobile-detect](https://github.com/riverskies/laravel-mobile-detect)
|
-->

<!-- Preconnect to required origins -->
<link rel="dns-prefetch" href="https://www.google-analytics.com">
<!-- End Preconnect to required origins -->

<!-- JS/CSS -->
<link rel="preload" as="script" href="{{ mix('js/app.js') }}">
<link rel="preload" as="style" href="{{ mix('css/app.css') }}">
<!-- End JS/CSS -->

<!-- Fonts/Media-->
{{-- Every browser that supports preloading also supports WOFF2, so that's always the format that we should preload. --}}
<link rel="preload" as="font" crossorigin="crossorigin" type="font/woff2" href="{{ asset('fonts/TradeGothic-Light.woff2') }}">
<link rel="preload" as="image" href="{{ webp('images/binalogue-logo.png') }}">

{{--
@route('home')

@desktop
<link rel="preload" as="image" href="{{ webp('images/binalogue-bg-home-desktop.jpg') }}">
@enddesktop

@mobile
<link rel="preload" as="image" href="{{ webp('images/binalogue-bg-home-mobile.jpg') }}">
@endmobile

@endroute
--}}
<!-- End Fonts/Media -->

<!--
|------------------------------------------------------------------------------
| Styles
|------------------------------------------------------------------------------
-->

<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

<!--
|------------------------------------------------------------------------------
| Head Scripts
|------------------------------------------------------------------------------
-->

<!-- Google Tag Manager -->
@if (config('services.google_tag_manager.id'))
<script>
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl+'{!! config('services.google_tag_manager.query') !!}';f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ config('services.google_tag_manager.id') }}');
</script>
@endif
<!-- End Google Tag Manager -->

<!-- Application Data -->
<script>
window.app_server_data = @json($data);
</script>
<!-- End Application Data -->

<!-- Application Routes -->
@routes
<!-- End Application Routes -->

<script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
@inertia
</body>
</html>
