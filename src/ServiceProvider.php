<?php


namespace iBrand\Aliyun\Vod;



class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config.php' => config_path('laravel-aliyun-vod.php'),
            ]);

        }

        $this->app->singleton('AliyunVod', function($app) {
            return new AliyunVod(config('laravel-aliyun-vod.aliyunvod.default'));
        });
    }

    public function provides()
    {
        return  [AliyunVod::class,'AliyunVod'];
    }

}