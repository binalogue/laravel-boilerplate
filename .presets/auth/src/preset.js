const { Preset } = require('use-preset');

module.exports = Preset.make('laravel-boilerplate-auth-preset')

  .copyTemplates()

  .editJson('composer.json')
  .title('➕ Add auth PHP dependencies')
  .merge({
    require: {
      'laravel/socialite': '^5.0',
    },
  })
  .chain()

  .edit('app/Support/Http/Kernel.php')
  .title('🏗 Add auth middlewares to HTTP kernel')
  .search(/@use-preset-auth-middleware$/)
  .addAfter([
    `'auth' => \\App\\Platform\\Auth\\Middleware\\Authenticate::class,`,
    `'password.reset' => \\App\\Platform\\Auth\\Middleware\\MustResetPassword::class,`,
    `'guest' => \\App\\Platform\\Auth\\Middleware\\RedirectIfAuthenticated::class,`,
  ])
  .end()
  .chain()

  .edit('app/Support/Providers/AuthServiceProvider.php')
  .title('🏗 Update AuthServiceProvider')
  .search(/@use-preset-auth-service-provider-policies$/)
  .addAfter([
    `\\Domain\\Users\\Models\\Role::class => \\Domain\\Users\\Policies\\RolePolicy::class,`,
    `\\Domain\\Users\\Models\\User::class => \\Domain\\Users\\Policies\\UserPolicy::class,`,
  ])
  .end()
  .search(/@use-preset-auth-service-provider-boot$/)
  .addAfter([
    `$this->app->bind(\\Domain\\Users\\Contracts\\Role::class, \\Domain\\Users\\Models\\Role::class);`,
    `\\Illuminate\\Support\\Facades\\Gate::define('viewAnyId', fn ($user) => $user->isSuperAdmin());`,
    `\\Illuminate\\Support\\Facades\\Gate::define('updateRoleAttribute', \\Domain\\Users\\Policies\\UserPolicy::class.'@updateRoleAttribute');`,
    `\\Illuminate\\Support\\Facades\\Gate::define('updateEmailAttribute', \\Domain\\Users\\Policies\\UserPolicy::class.'@updateEmailAttribute');`,
    `\\Illuminate\\Support\\Facades\\Gate::define('updatePasswordAttribute', \\Domain\\Users\\Policies\\UserPolicy::class.'@updatePasswordAttribute');`,
    `\\Illuminate\\Support\\Facades\\Gate::define('updateHasNotificationsEnabledAttribute', \\Domain\\Users\\Policies\\UserPolicy::class.'@updateHasNotificationsEnabledAttribute');`,
  ])
  .end()
  .chain()

  .edit('app/Support/Providers/EventServiceProvider.php')
  .title('🏗 Update EventServiceProvider')
  .search(/@use-preset-event-service-provider-subscribe$/)
  .addAfter(`\\Domain\\Users\\Subscribers\\UserSubscriber::class,`)
  .end()
  .search(/@use-preset-event-service-provider-boot-model-observers$/)
  .addAfter(
    `\\Domain\\Users\\Models\\User::observe(\\Domain\\Users\\Observers\\UserObserver::class);`
  )
  .end()
  .chain()

  .edit('app/Support/Providers/InertiaServiceProvider.php')
  .title('🏗 Update InertiaServiceProvider')
  .search(/@use-preset-inertia-service-provider-auth$/)
  .addAfter(
    `/** @var \\Support\\Eloquent\\User|null $user */
    $user = \\Illuminate\\Support\\Facades\\Auth::user();

    if (\\Illuminate\\Support\\Facades\\Auth::check() && ! is_null($user)) {
        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->first_name,
                'email' => $user->email,
            ],

            'notifications' => $user->unreadNotificationsMessages(),
        ];
    }`
  )
  .end()
  .chain()

  .edit('routes/web.php')
  .title('🏗 Add web routes')
  .search(/@use-preset-web-routes$/)
  .addAfter([
    `/*`,
    `|--------------------------------------------------------------------------`,
    `| Auth`,
    `|--------------------------------------------------------------------------`,
    `*/`,

    `// Authentication`,

    `Route::get('login', [\\App\\Platform\\Auth\\Controllers\\LoginController::class, 'showLoginForm'])
      ->name('login.form')
      ->middleware('guest');`,

    `Route::post('login', [\\App\\Platform\\Auth\\Controllers\\LoginController::class, 'login'])
      ->name('login')
      ->middleware('guest');`,

    `Route::post('logout', [\\App\\Platform\\Auth\\Controllers\\LoginController::class, 'logout'])
      ->name('logout');`,

    `// Pre Registration`,

    `Route::get('register', [\\App\\Platform\\Auth\\Controllers\\PreRegisterController::class, 'showPreRegisterForm'])
      ->name('preRegister.form')
      ->middleware('guest');`,

    `// Registration`,

    `Route::get('register/email', [\\App\\Platform\\Auth\\Controllers\\RegisterController::class, 'showRegisterForm'])
      ->name('register.form')
      ->middleware('guest');`,

    `Route::post('register', [\\App\\Platform\\Auth\\Controllers\\RegisterController::class, 'register'])
      ->name('register')
      ->middleware('guest');`,

    `// Email Verification`,

    `Route::get('email/verify', [\\App\\Platform\\Auth\\Controllers\\EmailVerificationController::class, 'showVerificationNotice'])
      ->name('verification.notice')
      ->middleware('auth');`,

    `Route::get('email/verify/{id}/{hash}', [\\App\\Platform\\Auth\\Controllers\\EmailVerificationController::class, 'verify'])
      ->name('verification.verify')
      ->middleware('auth', 'signed', 'throttle:6,1');`,

    `Route::post('email/resend', [\\App\\Platform\\Auth\\Controllers\\EmailVerificationController::class, 'resend'])
      ->name('verification.resend')
      ->middleware('auth', 'throttle:6,1');`,

    `// Socialite`,

    `Route::get('oauth/{driver}', [\\App\\Platform\\Auth\\Controllers\\SocialiteController::class, 'redirectToProvider'])
      ->where('driver', implode('|', config('socialite.drivers')))
      ->name('oauth')
      ->middleware('guest');`,

    `Route::get('oauth/{driver}/callback', [\\App\\Platform\\Auth\\Controllers\\SocialiteController::class, 'handleProviderCallback'])
      ->where('driver', implode('|', config('socialite.drivers')))
      ->name('oauth.callback');`,

    `// Password Reset`,

    `Route::get('password/reset', [\\App\\Platform\\Auth\\Controllers\\ForgotPasswordController::class, 'showLinkRequestForm'])
      ->name('password.request');`,

    `Route::post('password/email', [\\App\\Platform\\Auth\\Controllers\\ForgotPasswordController::class, 'sendResetLinkEmail'])
      ->name('password.email');`,

    `Route::get('password/reset/{token}', [\\App\\Platform\\Auth\\Controllers\\ResetPasswordController::class, 'showResetForm'])
      ->name('password.reset');`,

    `Route::post('password/reset', [\\App\\Platform\\Auth\\Controllers\\ResetPasswordController::class, 'reset'])
      ->name('password.update');`,

    `// Force Password Reset`,

    `Route::get('password/new', [\\App\\Platform\\Auth\\Controllers\\ForceResetPasswordController::class, 'showResetForm'])
      ->name('password.forceReset')
      ->middleware('auth');`,

    `Route::post('password/new', [\\App\\Platform\\Auth\\Controllers\\ForceResetPasswordController::class, 'reset'])
      ->name('password.forceResetUpdate')
      ->middleware('auth');`,

    `/*`,
    `|--------------------------------------------------------------------------`,
    `| Profile`,
    `|--------------------------------------------------------------------------`,
    `*/`,

    `Route::get('profile', [\\App\\Platform\\Users\\Controllers\\ProfileController::class, 'show'])
      ->name('profile.show')
      ->middleware('auth', 'verified', 'password.reset');`,

    `Route::get('profile/edit', [\\App\\Platform\\Users\\Controllers\\ProfileController::class, 'edit'])
      ->name('profile.edit')
      ->middleware('auth', 'verified', 'password.reset');`,

    `Route::put('profile', [\\App\\Platform\\Users\\Controllers\\ProfileController::class, 'update'])
      ->name('profile.update')
      ->middleware('auth', 'verified', 'password.reset');`,

    `Route::delete('profile', [\\App\\Platform\\Users\\Controllers\\ProfileController::class, 'destroy'])
      ->name('profile.destroy')
      ->middleware('auth', 'verified', 'password.reset');`,

    `Route::post('profile/avatar', [\\App\\Platform\\Users\\Controllers\\ProfileAvatarController::class, 'update'])
      ->name('profile.avatar')
      ->middleware('auth', 'verified', 'password.reset');`,

    `/*`,
    `|--------------------------------------------------------------------------`,
    `| Notifications`,
    `|--------------------------------------------------------------------------`,
    `*/`,

    `Route::delete('notifications/{notification}', \\App\\Platform\\Notifications\\Controllers\\NotificationsController::class)
      ->name('notifications.read');`,
  ])
  .end()
  .chain()

  .edit('routes/development.php')
  .title('🏗 Add development routes')
  .search(/@use-preset-development-routes$/)
  .addAfter([
    `// Mails to users...`,
    `\\Illuminate\\Support\\Facades\\Route::get('mails/users/registered', [\\App\\PlatformDev\\Mails\\Controllers\\MailsController::class, 'userRegistered']);`,
    `\\Illuminate\\Support\\Facades\\Route::get('mails/users/requested-verification', [\\App\\PlatformDev\\Mails\\Controllers\\MailsController::class, 'userRequestedVerification']);`,
    `\\Illuminate\\Support\\Facades\\Route::get('mails/users/verified', [\\App\\PlatformDev\\Mails\\Controllers\\MailsController::class, 'userVerified']);`,
    `\\Illuminate\\Support\\Facades\\Route::get('mails/users/forgot-password', [\\App\\PlatformDev\\Mails\\Controllers\\MailsController::class, 'userForgotPassword']);`,
  ])
  .end()
  .chain()

  .edit('database/seeders/DatabaseSeeder.php')
  .title('🌱 Add seeders')
  .search(/@use-preset-database-seeders$/)
  .addAfter([
    `$this->call(RolesTableSeeder::class);`,
    `$this->call(UsersTableSeeder::class);`,
  ])
  .end()
  .chain()

  .edit('config/services.php')
  .title('🔧 Add Google service')
  .search(/@use-preset-config-services$/)
  .addAfter(
    `'google' => [
      'client_id' => env('GOOGLE_CLIENT_ID'),
      'client_secret' => env('GOOGLE_CLIENT_SECRET'),
      'redirect' => '/oauth/google/callback',
    ],`
  )
  .end()
  .chain();
