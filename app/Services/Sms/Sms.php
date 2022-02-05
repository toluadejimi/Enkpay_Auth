<?php

namespace App\Services\Sms;

use Exception;
use App\DTOs\SmsResponse;
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
    public function send(array $attributes): array
    {
        retry(4, function () use ($attributes) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($this->base_url. '/api/sms/send', [
                'to' => $attributes['to'],
                'from' => $attributes['from'] ?? $this->from,
                'sms' => $attributes['message'],
                'type' => $this->type,
                'channel' => $this->channel,
                'api_key' => $this->api_key,
            ]);

            $this->status = $response->status();
            $this->response = $response->json();
        }, 5000);

        // log state

        return $this->status === 200
            ? $this->response
            : [];
    }

    public function balance()
    {
        // TODO: Implement balance() method.
    }
}
