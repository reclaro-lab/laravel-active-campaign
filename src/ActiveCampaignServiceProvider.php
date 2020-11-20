<?php

namespace ProjectRebel\ActiveCampaign;

use Illuminate\Support\ServiceProvider;
use ProjectRebel\ActiveCampaign\Facades\ActiveCampaign;

class ActiveCampaignServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('activecampaign', function ($app) {
            return new ActiveCampaign();
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'activecampaign');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('activecampaign.php'),
            ], 'config');
        }
    }
}
