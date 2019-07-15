<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--
|------------------------------------------------------------------------------
| SEO
|------------------------------------------------------------------------------
-->

@php
$currentRouteMeta = $data['meta'][Request::route()->getName()];
@endphp

<title>{{ $currentRouteMeta['title'] }}</title>

<meta name="description" content="{{ $currentRouteMeta['description'] }}" data-vue-router-controlled="">

<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph -->
<meta property="og:type"             content="website">
<meta property="og:locale"           content="{{ app()->getLocale() }}">
<meta property="og:site_name"        content="{{ config('app.name') }}">
<meta property="og:url"              content="{{ url()->current() }}"                  data-vue-router-controlled="">
<meta property="og:title"            content="{{ $currentRouteMeta['title'] }}"        data-vue-router-controlled="">
<meta property="og:description"      content="{{ $currentRouteMeta['description'] }}"  data-vue-router-controlled="">
<meta property="og:image"            content="{{ $currentRouteMeta['image'] }}"        data-vue-router-controlled="">
<meta property="og:image:secure_url" content="{{ $currentRouteMeta['image'] }}"        data-vue-router-controlled="">
<meta property="og:image:width"      content="{{ $currentRouteMeta['image_width'] }}"  data-vue-router-controlled="">
<meta property="og:image:height"     content="{{ $currentRouteMeta['image_height'] }}" data-vue-router-controlled="">
<meta property="og:image:alt"        content="{{ $currentRouteMeta['title'] }}"        data-vue-router-controlled="">
<meta property="og:image:type"       content="image/jpeg">
<!-- End Open Graph -->

<!-- Facebook Sharing: https://developers.facebook.com/tools/debug/ -->
<meta property="fb:app_id"           content="{{ config('services.facebook.app_id') }}">
<!-- End Facebook Sharing -->

<!-- Twitter Cards: https://cards-dev.twitter.com/validator -->
<meta name="twitter:card"            content="summary_large_image">
<meta name="twitter:title"           content="{{ $currentRouteMeta['title'] }}"        data-vue-router-controlled="">
<meta name="twitter:description"     content="{{ $currentRouteMeta['description'] }}"  data-vue-router-controlled="">
<meta name="twitter:image"           content="{{ $currentRouteMeta['image'] }}"        data-vue-router-controlled="">
<meta name="twitter:site"            content="{{ config('services.twitter.site') }}">
<meta name="twitter:creator"         content="{{ config('services.twitter.creator') }}">
<!-- End Twitter Cards -->

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

<!-- Vue.js Data -->
<script>
    window.csrf_token = "{{ csrf_token() }}";
    window.app_server_data = @json($data);
</script>
<!-- End Vue.js Data -->

<!-- Global Site Tag (gtag.js) - Google Analytics -->
@env('production')
{{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX-X"></script> --}}
@else
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.googleanalytics.id') }}"></script>
@endenv
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {dataLayer.push(arguments);}
    gtag('js', new Date());
</script>
<!-- End Global Site Tag (gtag.js) - Google Analytics -->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<main id="app"></main>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
