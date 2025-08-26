<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TaxonomyRepository;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(TaxonomyRepository $taxonomyRepository)
    {
        View::composer('ecommerce.shared.app', function ($view) use ($taxonomyRepository) {
            $view->with('taxonomies', $taxonomyRepository->homePage());
        });
    }
}
