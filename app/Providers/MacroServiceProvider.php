<?php

namespace sifmedtec\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('paginateIf', function() {
            if(request()->has('page')) {
                return $this->paginate();
            }
            return $this->get();
        });
    }
}
