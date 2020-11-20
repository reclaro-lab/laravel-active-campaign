<?php

namespace ProjectRebel\ActiveCampaign\Facades;

use Illuminate\Support\Facades\Facade;

class ActiveCampaign extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'activecampaign';
    }
}