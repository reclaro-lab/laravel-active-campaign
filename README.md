# Active Campaign for Laravel

A fluent wrapper around version 3 of the [Active Campaign API](https://developers.activecampaign.com/reference).

## Installation
The first thing to do is require the package using composer.

    composer require projectrebel/laravel-active-campaign

Next, you'll need to add the service provider and facade to the related arrays in `config/app.php`

    'providers' = [
        ...
        ProjectRebel\ActiveCampaign\ActiveCampaignServiceProvider::class,
        ...
    ];
    
    'aliases' => [
        ...
        'ActiveCampaign' => ProjectRebel\ActiveCampaign\Facades\ActiveCampaign::class,
        ...
    ];

Once the package has been installed, you can publish the package's configuration to `config/activecampaign.php`.

    php artisan vendor:publish --provider="ProjectRebel\ActiveCampaign\ActiveCampaignServiceProvider" --tag="config"

Then add your Active Campaign key and subdomain to your `.env` file.

    ACTIVE_CAMPAIGN_KEY=your-key
    ACTIVE_CAMPAIGN_SUBDOMAIN=your-subdomain


## Usage
More documentation very coming soon.

##### Available Commands
- init
- listContacts
- createContact
- syncContact
- addContactToList
- unsubscribeContactFromList
- searchForTag
- addTagToContact
