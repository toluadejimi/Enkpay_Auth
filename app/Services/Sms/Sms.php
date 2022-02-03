<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class Sms
{
    protected string $type;
    protected string $channel;
    protected string $api_key;
    protected string $base_url;

    public function __construct()
    {
        $this->type = config('services.sms.type');
        $this->channel = config('services.sms.channel');
        $this->api_key = config('services.sms.api_key');
        $this->base_url = config('services.sms.base_url');
    }

    /**
     * @throws RequestException
     */
    public function send(array $attributes)
    {
        return Http::get($this->base_url, [
            'to' => $attributes['to'],
            'from' => $attributes['from'],
            'sms' => $attributes['message'],
            'type' => $this->type,
            'channel' => $this->channel,
            'api_key' => $this->api_key,
        ])->throw()->json();

        // Log response details (filter number out)
    }

    public function balance()
    {
        // TODO: Implement balance() method.
    }
}
