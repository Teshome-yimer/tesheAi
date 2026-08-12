<?php

namespace App\Providers;

use App\Models\Course;
use App\Policies\CoursePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Course::class, CoursePolicy::class);

        if (app()->environment('production') || request()->header('x-forwarded-proto') === 'https' || isset($_SERVER['HTTPS'])) {
            URL::forceScheme('https');
        }

        // Rate Limiter: በ 1 ደቂቃ ውስጥ ከ 5 ጊዜ በላይ የተሳሳተ Login እንዳይደረግ ይከለክላል
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });
    }
}