<?php

namespace App\Providers;

use App\Models\Course;
use App\Policies\CoursePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
    }
}
