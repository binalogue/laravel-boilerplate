@if ($logo = nova_get_setting('admin_logo'))
{!! $logo !!}
@else
<svg
    class="fill-current"
    width="{{ $width ?? '236' }}"
    height="{{ $height ?? '40' }}"
    viewBox="{{ $viewBox ?? '0 0 236 40' }}"
    xmlns="http://www.w3.org/2000/svg"
>
    <path d="m0 .138h6.239v6.234h-6.239z" fill="#ff9a22"/>
    <path d="m229.768 25.073h6.232v6.231h-6.232z" fill="#ff9a22"/>
    <g>
        <path d="m66.019.138h6.241v6.234h-6.241z"/>
        <path d="m0 12.618h6.229v18.689h-6.229z"/>
        <path d="m15.574 12.618v12.455h12.42v-18.701h-18.647v-6.234h24.893v31.163h-24.893v-18.683z"/>
        <path d="m37.344.135h14.667c5.937 0 9.952 1.92 9.952 7.731 0 3.053-1.527 5.192-4.23 6.5 3.798 1.093 5.72 4.015 5.72 7.904 0 6.332-5.37 9.037-11.005 9.037h-15.104zm6.848 12.62h6.945c2.404 0 4.19-1.094 4.19-3.714 0-2.969-2.27-3.581-4.715-3.581h-6.421v7.295zm0 13.227h7.338c2.711 0 5.065-.872 5.065-4.105 0-3.186-2.007-4.451-4.934-4.451h-7.47v8.556z"/>
        <path d="m66.022 8.738h6.234v22.569h-6.234z"/>
        <path d="m75.337 8.738h5.893v3.142h.134c1.57-2.536 4.278-3.756 6.897-3.756 6.593 0 8.254 3.711 8.254 9.302v13.882h-6.202v-12.75c0-3.707-1.093-5.544-3.972-5.544-3.365 0-4.804 1.878-4.804 6.464v11.831h-6.2z"/>
        <path d="m99.695 15.678c.35-5.809 5.549-7.554 10.612-7.554 4.498 0 9.912 1.002 9.912 6.416v11.748c0 2.05.215 4.101.783 5.02h-6.288c-.216-.7-.393-1.441-.434-2.179-1.966 2.048-4.847 2.793-7.601 2.793-4.275 0-7.684-2.142-7.684-6.771 0-5.106 3.841-6.329 7.684-6.853 3.801-.569 7.336-.44 7.336-2.968 0-2.666-1.832-3.061-4.018-3.061-2.354 0-3.881.965-4.101 3.409zm14.322 4.583c-1.047.916-3.228.961-5.149 1.31-1.922.395-3.666 1.049-3.666 3.32 0 2.313 1.789 2.878 3.795 2.878 4.847 0 5.021-3.841 5.021-5.195v-2.313z"/>
        <path d="m123.333.135h6.201v31.173h-6.201z"/>
        <path d="m143.75 8.124c7.121 0 11.704 4.715 11.704 11.921 0 7.16-4.583 11.877-11.704 11.877-7.068 0-11.656-4.717-11.656-11.877 0-7.206 4.588-11.921 11.656-11.921zm0 19.121c4.236 0 5.505-3.623 5.505-7.2 0-3.624-1.269-7.25-5.505-7.25-4.189 0-5.453 3.626-5.453 7.25 0 3.577 1.264 7.2 5.453 7.2z"/>
        <path d="m180.029 29.866c0 3.71-1.305 9.999-11.696 9.999-4.455 0-9.648-2.097-9.956-7.245h6.151c.574 2.309 2.447 3.098 4.636 3.098 3.446 0 5.019-2.361 4.975-5.587v-2.971h-.086c-1.356 2.355-4.063 3.494-6.77 3.494-6.771 0-9.646-5.154-9.646-11.353 0-5.848 3.361-11.178 9.69-11.178 2.967 0 5.24 1.002 6.726 3.622h.086v-3.007h5.891v21.128zm-5.89-10.127c0-3.668-1.266-6.944-5.285-6.944-3.491 0-5.021 3.06-5.021 6.42 0 3.23 1.225 6.768 5.021 6.768 3.536-.001 5.285-3.013 5.285-6.244z"/>
        <path d="m203.635 31.308h-5.893v-3.144h-.136c-1.572 2.534-4.276 3.758-6.897 3.758-6.592 0-8.253-3.714-8.253-9.302v-13.882h6.203v12.747c0 3.708 1.091 5.545 3.975 5.545 3.361 0 4.798-1.879 4.798-6.461v-11.831h6.203z"/>
        <path d="m217.24 12.794c-3.927 0-5.065 3.058-5.148 4.805h10.081c-.568-3.143-1.918-4.805-4.933-4.805z" fill="none"/>
        <path d="m217.415 8.124c-6.851 0-11.524 5.153-11.524 11.92 0 6.986 4.41 11.878 11.524 11.878 4.863 0 8.454-2.064 10.296-6.849h-5.564c-.762 1.142-2.466 2.172-4.513 2.172-3.445 0-5.369-1.785-5.542-5.72h16.28c.44-6.94-3.273-13.401-10.957-13.401zm-5.323 9.475c.083-1.747 1.222-4.805 5.148-4.805 3.015 0 4.365 1.661 4.933 4.805z"/>
    </g>
</svg>
@endif
