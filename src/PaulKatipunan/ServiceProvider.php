<?php 

namespace PaulKatipunan;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        include 'routes/api.php';

        $this->publishes([
           __DIR__.'/views/email/reset-password.blade.php' => resource_path('/views/email/reset-password.blade.php'),
        ],'email-template');
        
        $this->publishes([
           __DIR__.'/views/email/change-password.blade.php' => resource_path('/views/email/change-password.blade.php'),
        ],'change-password-blade-file');

        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       


    }

}
