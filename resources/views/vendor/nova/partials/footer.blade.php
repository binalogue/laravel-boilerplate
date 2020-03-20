<p class="flex items-center justify-center mt-8 text-center text-xs text-80">
    &copy; {{ date('Y') }} <a href="https://binalogue.com" class="ml-1 text-primary no-underline">Binalogue</a>

    <span class="px-1">&middot;</span>

    @include('vendor.nova.partials.footer_logo')

    <span class="px-1">&middot;</span>

    Made with <a href="https://nova.laravel.com" class="ml-1 text-primary no-underline">Laravel Nova</a>

    <span class="px-1">&middot;</span>

    v{{ \Laravel\Nova\Nova::version() }}
</p>
