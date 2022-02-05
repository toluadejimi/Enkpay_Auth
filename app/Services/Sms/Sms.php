<?php

namespace App\Services\Sms;

use Exception;
use Illuminate\Support\Facades\Http;

class Sms
{
    protected string $type;
    protected string $from;
    protected string $channel;
    protected string $api_key;
    protected string $base_url;

    protected int $status;
    protected mixed $response;

    public function __construct()
    {
        $this->from = config('services.sms.from');
        $this->type = config('services.sms.type');
        $this->channel = config('services.sms.channel');
        $this->api_key = config('services.sms.api_key');
        $this->base_url = config('services.sms.base_url');
    }

    /** @throws Exception */
    public function send(array $attributes)
    {
        $time = now()->format('Y-m-d H:i:s');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($this->base_url. '/api/sms/send', [
            'to' => $attributes['to'],
            'from' => empty($attributes['from']) ? $this->from : $attributes['from'],
            'sms' => $attributes['message'],
            'type' => $this->type,
            'channel' => $this->channel,
            'api_key' => $this->api_key,
        ])->json();

        activity()->log("{$time}::{$response['message']}");
    }

    public function balance()
    {
        // TODO: Implement balance() method.
    }
}
