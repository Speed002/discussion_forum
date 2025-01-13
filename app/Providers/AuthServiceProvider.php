<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Discussion;
use App\Policies\DiscussionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    // This is where we register all our policies
    // As long as a policy is registered here, it will be considered.. before proceeding
    protected $policies = [
        // Each time this module is used, this policy will be in place ready to act
        Discussion::class => DiscussionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
