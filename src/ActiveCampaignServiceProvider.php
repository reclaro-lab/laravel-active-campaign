<?php

namespace ProjectRebel\ActiveCampaign;

use Illuminate\Support\ServiceProvider;
use ProjectRebel\ActiveCampaign\Models\ActiveCampaign;

class ActiveCampaignServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'activecampaign');

        $this->app->bind('activecampaign', function ($app) {
            return new ActiveCampaign(config('activecampaign.key', 'key'), config('activecampaign.subdomain', 'subdomain'));
        });
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
