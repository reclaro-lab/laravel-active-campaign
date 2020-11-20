# Active Campaign for Laravel

A fluent wrapper around version 3 of the [https://developers.activecampaign.com/reference](Active Campaign API).

## Installation
The first thing to do is require the package using composer.

    composer require projectrebel/laravel-active-campaign

Once the package has been installed, you can publish the package's configuration to `config/activecampaign.php`.

    php artisan vendor:publish --provider="ProjectRebel\ActiveCampaign\ActiveCampaignServiceProvider" --tag="config"

Then add your Active Campaign key and URL to your `.env` file.

    ACTIVE_CAMPAIGN_KEY=your-key
    ACTIVE_CAMPAIGN_URL=your-url


## Usage
More documentation coming soon.
