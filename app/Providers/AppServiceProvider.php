<?php

namespace TargetInk\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $clientDropList = [];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(!app()->runningInConsole() || env('PHPUNIT', false)) {
            $init = ['' => 'Choose a Client...'];
            $this->clientDropList = \TargetInk\User::where('admin', 0)->orderBy('company')->lists('company', 'id')->toArray();

            if($this->clientDropList) {
                $init = $init + $this->clientDropList;
            }

            view()->share('clientDropList', $init);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
