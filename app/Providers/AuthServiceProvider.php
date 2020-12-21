<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Todo: Move Token validation to database
        $this->app['auth']->viaRequest('api', function ($request) {
            if (app()->environment('local')) {
                return new GenericUser(['id' => 1, 'name' => 'API User']);
            }

            if ($request->header('Authorization')) {
                $authKey = $request->header('Authorization');
                $environment = app()->environment();

                if (!empty(config('api.app_keys')[$environment])
                    && config('api.app_keys')[$environment] === $authKey
                ) {
                    return new GenericUser(['id' => 1, 'name' => 'API User']);
                }
            }
            return null;
        });
    }
}
