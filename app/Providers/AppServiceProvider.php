<?php

namespace App\Providers;

use App\Channel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
//        Schema::defaultStringLength(191);

        // 时间本地化设置
        Carbon::setLocale('zh');

        // 在视图中共享数据
//        \View::share('channels',\App\Channel::all());
        \View::composer('*', function ($view) {
//            $view->with('channels', Channel::all());
            // 缓存 channels 数据
            $channels = \Cache::rememberForever('channels', function () {
                return Channel::all();
            });
            $view->with('channels', $channels);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 安装 Laravel 开发者工具类 - laravel-debugbar。
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
