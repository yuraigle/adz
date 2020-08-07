<?php

namespace App\Providers;

use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function (Request $request) {
            $token = $request->header("Authorization");

            if ($token) {
                $rowToken = DB::selectOne(
                    "SELECT user_id FROM adz_user_token WHERE token = ? AND expires_at > NOW()",
                    [$token]
                );

                if (!$rowToken) return null;

                $rowUser = DB::selectOne(
                    "SELECT id, name, email, role FROM adz_user WHERE id = ?",
                    [$rowToken->user_id]);

                if (!$rowUser) return null;

                return new GenericUser((array)$rowUser);
            }

            return null;
        });
    }
}
