<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
   public function register()
   {
      $helperFile = app_path('Helpers/Helper.php');
      if(file_exists($helperFile)) {
         require_once($helperFile);
      }
   }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
