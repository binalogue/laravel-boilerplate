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
  .search(/<?php$/)
  .addAfter([
    `use Domain\\Users\\Contracts\\Role as RoleContract;`,
    `use Domain\\Users\\Models\\Role;`,
    `use Domain\\Users\\Models\\User;`,
    `use Domain\\Users\\Policies\\RolePolicy;`,
    `use Domain\\Users\\Policies\\UserPolicy;`,
    `use Illuminate\\Support\\Facades\\Gate;`,
  ])
  .end()
  .search(/@use-preset-auth-service-provider-policies$/)
  .addAfter([
    `Role::class => RolePolicy::class,`,
    `User::class => UserPolicy::class,`,
  ])
  .end()
  .search(/@use-preset-auth-service-provider-boot$/)
  .addAfter([
    `$this->app->bind(RoleContract::class, Role::class);`,
    `Gate::define('view-any-id', fn ($user) => $user->isSuperAdmin());`,
    `Gate::define('update-role-attribute', UserPolicy::class.'@updateRoleAttribute');`,
    `Gate::define('update-email-attribute', UserPolicy::class.'@updateEmailAttribute');`,
    `Gate::define('update-password-attribute', UserPolicy::class.'@updatePasswordAttribute');`,
    `Gate::define('update-has-notifications-enabled-attribute', UserPolicy::class.'@updateHasNotificationsEnabledAttribute');`,
  ])
  .end()
  .chain()

  .edit('app/Support/Providers/EventServiceProvider.php')
  .title('🏗 Update EventServiceProvider')
  .search(/<?php$/)
  .addAfter([
    `use Domain\\Users\\Models\\User;`,
    `use Domain\\Users\\Observers\\UserObserver;`,
    `use Domain\\Users\\Subscribers\\UserSubscriber;`,
  ])
  .end()
  .search(/@use-preset-event-service-provider-subscribe$/)
  .addAfter(`UserSubscriber::class,`)
  .end()
  .search(/@use-preset-event-service-provider-boot-model-observers$/)
  .addAfter(`User::observe(UserObserver::class);`)
  .end()
  .chain()

  .edit('app/Support/Providers/InertiaServiceProvider.php')
  .title('🏗 Update InertiaServiceProvider')
  .search(/<?php$/)
  .addAfter(`use Illuminate\\Support\\Facades\\Auth;`)
  .end()
  .search(/@use-preset-inertia-service-provider-auth$/)
  .addAfter(
    `/** @var \\Support\\Eloquent\\User|null $user */
    $user = Auth::user();

    if (Auth::check() && ! is_null($user)) {
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
  .search(/<?php$/)
  .addAfter([
    `use App\\Platform\\Auth\\Controllers\\EmailVerificationController;`,
    `use App\\Platform\\Auth\\Controllers\\ForceResetPasswordController;`,
    `use App\\Platform\\Auth\\Controllers\\ForgotPasswordController;`,
    `use App\\Platform\\Auth\\Controllers\\LoginController;`,
    `use App\\Platform\\Auth\\Controllers\\PreRegisterController;`,
    `use App\\Platform\\Auth\\Controllers\\RegisterController;`,
    `use App\\Platform\\Auth\\Controllers\\ResetPasswordController;`,
    `use App\\Platform\\Auth\\Controllers\\SocialiteController;`,
    `use App\\Platform\\Notifications\\Controllers\\NotificationsController;`,
    `use App\\Platform\\Users\\Controllers\\ProfileController;`,
    `use App\\Platform\\Users\\Controllers\\UpdateProfileAvatarController;`,
  ])
  .end()
  .search(/@use-preset-web-routes$/)
  .addAfter([
    `/*`,
    `|--------------------------------------------------------------------------`,
    `| Auth`,
    `|--------------------------------------------------------------------------`,
    `*/`,

    `// Authentication`,

    `Route::get('login', [LoginController::class, 'showLoginForm'])
      ->name('login.form')
      ->middleware('guest');`,

    `Route::post('login', [LoginController::class, 'login'])
      ->middleware('guest');`,

    `Route::post('logout', [LoginController::class, 'logout'])
      ->name('logout');`,

    `// Pre Registration`,

    `Route::get('register', [PreRegisterController::class, 'showPreRegisterForm'])
      ->name('preRegister.form')
      ->middleware('guest');`,

    `// Registration`,

    `Route::get('register/email', [RegisterController::class, 'showRegisterForm'])
      ->name('register.form')
      ->middleware('guest');`,

    `Route::post('register', [RegisterController::class, 'register'])
      ->name('register')
      ->middleware('guest');`,

    `// Email Verification`,

    `Route::get('email/verify', [EmailVerificationController::class, 'showVerificationNotice'])
      ->name('verification.notice')
      ->middleware('auth');`,

    `Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
      ->name('verification.verify')
      ->middleware('auth', 'signed', 'throttle:6,1');`,

    `Route::post('email/resend', [EmailVerificationController::class, 'resend'])
      ->name('verification.resend')
      ->middleware('auth', 'throttle:6,1');`,

    `// Socialite`,

    `Route::get('oauth/{driver}', [SocialiteController::class, 'redirectToProvider'])
      ->where('driver', implode('|', config('socialite.drivers')))
      ->name('oauth')
      ->middleware('guest');`,

    `Route::get('oauth/{driver}/callback', [SocialiteController::class, 'handleProviderCallback'])
      ->where('driver', implode('|', config('socialite.drivers')))
      ->name('oauth.callback');`,

    `// Password Reset`,

    `Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
      ->name('password.request');`,

    `Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
      ->name('password.email');`,

    `Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
      ->name('password.reset');`,

    `Route::post('password/reset', [ResetPasswordController::class, 'reset'])
      ->name('password.update');`,

    `// Force Password Reset`,

    `Route::get('password/new', [ForceResetPasswordController::class, 'showResetForm'])
      ->name('password.forceReset')
      ->middleware('auth');`,

    `Route::post('password/new', [ForceResetPasswordController::class, 'reset'])
      ->name('password.forceResetUpdate')
      ->middleware('auth');`,

    `/*`,
    `|--------------------------------------------------------------------------`,
    `| Profile`,
    `|--------------------------------------------------------------------------`,
    `*/`,

    `Route::get('profile', [ProfileController::class, 'show'])
      ->name('profile.show')
      ->middleware('auth', 'verified', 'password.reset');`,

    `Route::get('profile/edit', [ProfileController::class, 'edit'])
      ->name('profile.edit')
      ->middleware('auth', 'verified', 'password.reset');`,

    `Route::put('profile', [ProfileController::class, 'update'])
      ->name('profile.update')
      ->middleware('auth', 'verified', 'password.reset');`,

    `Route::delete('profile', [ProfileController::class, 'destroy'])
      ->name('profile.destroy')
      ->middleware('auth', 'verified', 'password.reset');`,

    `Route::post('profile/avatar', UpdateProfileAvatarController::class)
      ->name('profile.avatar')
      ->middleware('auth', 'verified', 'password.reset');`,

    `/*`,
    `|--------------------------------------------------------------------------`,
    `| Notifications`,
    `|--------------------------------------------------------------------------`,
    `*/`,

    `Route::delete('notifications/{notification}', NotificationsController::class)
      ->name('notifications.read');`,
  ])
  .end()
  .chain()

  .edit('routes/development.php')
  .title('🏗 Add development routes')
  .search(/<?php$/)
  .addAfter([
    `use App\\PlatformDev\\Mails\\Controllers\\MailsController;`,
    `use Illuminate\\Support\\Facades\\Route;`,
  ])
  .end()
  .search(/@use-preset-development-routes$/)
  .addAfter([
    `// Mails to users...`,
    `Route::get('/mails/users/registered', [MailsController::class, 'userRegistered']);`,
    `Route::get('/mails/users/requested-verification', [MailsController::class, 'userRequestedVerification']);`,
    `Route::get('/mails/users/verified', [MailsController::class, 'userVerified']);`,
    `Route::get('/mails/users/forgot-password', [MailsController::class, 'userForgotPassword']);`,
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
