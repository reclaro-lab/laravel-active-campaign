<?php

namespace ProjectRebel\ActiveCampaign\Tests;

use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ProjectRebel\ActiveCampaign\Models\ActiveCampaign;
use ProjectRebel\ActiveCampaign\ActiveCampaignServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected $ac;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->ac = new ActiveCampaign('key', 'subdomain');
    }

    protected function getPackageProviders($app)
    {
        return [
            ActiveCampaignServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //
    }
}
