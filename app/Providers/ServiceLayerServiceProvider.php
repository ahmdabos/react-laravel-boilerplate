<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider,
    App\Services\SignUpService,
    App\Services\OauthService,
    App\Services\LoginService,
    App\Services\LogoutService,
    App\Services\ResetPasswordService,
    App\Services\ForgotPasswordLinkService;

class ServiceLayerServiceProvider extends ServiceProvider
{
  public function register() {
    /**
     * Resolve Services as application singletons
     */
    $this->app->singleton(
      'App\Services\SignUpService', function($app) {
        return new SignUpService(
          $app->make('Illuminate\Contracts\Validation\Factory'),
          $app->make('App\Contracts\Repository\UserRepositoryContract'),
          $app->make('Illuminate\Contracts\Routing\ResponseFactory'),
          $app->make('Laravel\Passport\ApiTokenCookieFactory')
        );
      }
    );

    $this->app->singleton(
      'App\Services\OauthService', function($app) {
        return new OauthService(
          $app->make('Illuminate\Contracts\Routing\ResponseFactory')
        );
      }
    );

    $this->app->singleton(
      'App\Services\LoginService', function($app) {
        return new LoginService(
          $app->make('Illuminate\Contracts\Auth\Factory'),
          $app->make('Illuminate\Contracts\Validation\Factory'),
          $app->make('Laravel\Passport\ApiTokenCookieFactory'),
          $app->make('Illuminate\Contracts\Routing\ResponseFactory')
        );
      }
    );

    $this->app->singleton(
      'App\Services\LogoutService', function($app) {
        return new LogoutService(
          $app->make('Illuminate\Contracts\Auth\Factory'),
          $app->make('Illuminate\Contracts\Cookie\Factory'),
          $app->make('Illuminate\Contracts\Routing\ResponseFactory')
        );
      }
    );

    $this->app->singleton(
      'App\Services\ForgotPasswordLinkService', function($app) {
        return new ForgotPasswordLinkService(
          $app->make('Illuminate\Contracts\Routing\ResponseFactory'),
          $app->make('Illuminate\Contracts\Auth\PasswordBroker')
        );
      }
    );

    $this->app->singleton(
      'App\Services\ResetPasswordService', function($app) {
        return new ResetPasswordService(
          $app->make('Illuminate\Contracts\Routing\ResponseFactory'),
          $app->make('Illuminate\Contracts\Auth\PasswordBroker')
        );
      }
    );
  }
}
