<?php

namespace NotificationChannels\Clicksend;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use NotificationChannels\Clicksend\Exceptions\InvalidConfiguration;

class ClicksendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(ClicksendChannel::class)
            ->needs(ClicksendClient::class)
            ->give(function () {
                $config = config('services.clicksend');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new ClicksendClient(new Client(), $config['access_key']);
            });
    }
}
