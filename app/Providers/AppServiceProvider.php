<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // 注册mail
        $this->app->singleton('mailer', function ($app) {
            $app->configure('services');
            $app->configure('mail');

            return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');
        });

        // 处理dingo的findOrFail 问题
        // 或许可以放在  ApiExceptionServiceProvider 这样的地方
        app('api.exception')->register(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        });
    }

    public function boot()
    {
        //添加自定义验证规则
        /*Validator::extend('json2', function($attribute, $value, $parameters) {
           try{
               \GuzzleHttp\json_decode($value);
               return true;
           } catch(ValidationException $exception) {

           }
            return false;

        });*/
    }
}
