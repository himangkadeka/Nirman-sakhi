<?php

namespace App\Providers;

use App\Services\AES;
use App\Services\AesCipher;
use App\Services\ApiCurlService;
use App\Services\GetVaultDataService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Services\ContentService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AesCipher::class, function ($app) {
            $initVector = 'wertyuiofghjk';
            return new AesCipher($initVector);
        });

        $this->app->singleton(ApiCurlService::class, function ($app) {
            return new ApiCurlService();
        });
    }

    public function boot()
    {
        View::composer('worker.leftmenu', function ($view) {
            $workerName = null;
            $workerSession = session()->get('worker');
            if ($workerSession && isset($workerSession->worker_id)) {
                try {
                    $vaultDataService = app(GetVaultDataService::class);
                    $vaultData = $vaultDataService->getVaultData($workerSession->worker_id, 'F');
                    $vaultDataArray = json_decode($vaultData->getData(), true);
                    $workerName = $vaultDataArray['name'] ?? null;
                } catch (\Exception $e) {
                    $workerName = null;
                }
            }
            $view->with('getVaultData', ['name' => $workerName]);
        });

        Paginator::useTailwind();
        Validator::extend('custom_rule', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[A-Za-z ,.\-]+$/', $value);
        });

        Validator::replacer('custom_rule', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute contains invalid characters.');
        });

        Validator::extend('assamese_script', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return true;
            }
            return preg_match('/^[\x{0980}-\x{09FF}0-9 \'\[\]।.' . "’" . ',\-:()\n]+$/u', $value);
        });
    }
}