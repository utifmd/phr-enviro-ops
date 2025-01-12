<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkTripPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Post::class, PostPolicy::class);

        Gate::define(UserPolicy::IS_NOT_GUEST_ROLE, [UserPolicy::class, 'isUserRoleIsNotGuest']);
        Gate::define(UserPolicy::IS_USER_IS_PM_COW_N_DEV, [UserPolicy::class, 'isUserIsPmCowAndDev']);
        Gate::define(UserPolicy::IS_USER_IS_PM_COW, [UserPolicy::class, 'isUserIsPmCow']);
        Gate::define(UserPolicy::IS_USER_IS_VT_CREW, [UserPolicy::class, 'isUserIsVtCrew']);
        Gate::define(UserPolicy::IS_USER_IS_FAC_OPE_N_DEV, [UserPolicy::class, 'isUserIsFacOpeAndDev']);
        Gate::define(UserPolicy::IS_USER_IS_FAC_REP, [UserPolicy::class, 'isUserIsFacRep']);
        Gate::define(UserPolicy::IS_USER_IS_PLANNER, [UserPolicy::class, 'isUserIsPlanner']);
        Gate::define(UserPolicy::IS_DEV_ROLE, [UserPolicy::class, 'isUserRoleIsDev']);

        Gate::define(PostPolicy::IS_USER_OR_PHR_OWNED, [PostPolicy::class, 'isPhrOrUserOwnThePost']);
        Gate::define(PostPolicy::IS_USER_OWNED, [PostPolicy::class, 'isUserOwnThePost']);
        Gate::define(PostPolicy::IS_THE_POST_STILL_PENDING, [PostPolicy::class, 'isThePostStillPending']);

        Gate::define(WorkTripPolicy::IS_WORK_TRIP_CREATED, [WorkTripPolicy::class, 'isWorkTripCreated']);

        Gate::define(UserPolicy::IS_USER_HAS_CURRENT_POST, [UserPolicy::class, 'isUserHasCurrentPost']);
    }
}
