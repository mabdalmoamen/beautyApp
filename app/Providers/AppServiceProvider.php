<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Mixins;
use App\Models\Point;
use App\Service\TenantServcie;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

use DB;
use Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Tenants', function () {
            return new TenantServcie();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->app->bind('path.public', function () {
        //     return base_path() . '/../public_html/gusto';
        // });
        $this->validatePoint();

        view()->composer('*', function ($view) {
            try {
                DB::connection()->getPDO();
                $codies = Mixins::where('id', 1)->first();
                $view->with('codies', $codies);
            } catch (Exception $e) {
                $view->with('codies', null);
            }
        });
    }
    public function validatePoint()
    {
        $points = Point::where('is_valid', true)->where('valid_to', "<", now())->get();
        foreach ($points as $point) {
            if (Carbon::parse($point->valid_to)->isPast()) {
                $point->update(['is_valid' => false]);
                Customer::where('cust_id', $point->cust_id)->update(['points' => DB::raw('points -' . $point->point_count)]);
            }
        }
    }
}
