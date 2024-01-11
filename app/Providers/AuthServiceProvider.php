<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Team;
use App\Models\User;
use App\Policies\LanguageLinePolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\TranslationLoader\LanguageLine;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        LanguageLine::class => LanguageLinePolicy::class,
        Team::class => TeamPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
