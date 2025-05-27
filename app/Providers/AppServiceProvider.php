<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\VisaDocument;
use Illuminate\Support\Facades\Auth;

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
  public function boot()
{
    View::composer('*', function ($view) {
        $visa = Auth::check()
            ? \App\Models\VisaDocument::where('candidate_id', Auth::id())->latest()->first()
            : null;

        $view->with('hasVisa', !!$visa)->with('latestVisa', $visa);
    });
}

}
