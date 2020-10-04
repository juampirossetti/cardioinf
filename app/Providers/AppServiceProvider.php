<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

use Illuminate\Support\Facades\Blade;

use App\Models\Membership\Membership;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        setlocale(LC_TIME, 'es_ES.utf8');
        //date_default_timezone_set('CET');
        Carbon::setLocale('es_ES.utf8'); // app()->getDateFormat() ??

        Carbon::setToStringFormat('d-m-Y');

        Blade::directive('siteMembership', function ($expression) {
            
            $memberships = explode(",",str_replace("'","",$expression));

            $site_membership = Membership::first();
            
            $condition = 0;
        
            foreach($memberships as $m){
                if($site_membership->name == $m){
                    $condition = 1;
                    break;
                }
            }             

            return '<?php if ('. $condition .') { ?>';
        });

        Blade::directive('endSiteMembership', function () {
            return "<?php } ?>";
        });
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
