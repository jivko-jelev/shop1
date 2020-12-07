<?php

namespace App\Providers;

use App\Category;
use App\Observers\PictureObserver;
use App\Observers\ThumbnailObserver;
use App\Picture;
use App\Thumbnail;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        Validator::extend('name', function ($attribute, $value, $parameters, $validator) {
            return preg_match("/^[\p{Cyrillic}\- ]+$/u", $value);
        });

        if (Schema::hasTable('categories')) {
            View::share('categories', Category::all());
        }

        Blade::directive('priceText', function ($expression) {
            return "<?php echo str_replace('.', '<sup>', (number_format((float)$expression, 2, '.', ''))) . '</sup> лв.';?>";
        });

        Picture::observe(PictureObserver::class);
        Thumbnail::observe(ThumbnailObserver::class);
    }
}
