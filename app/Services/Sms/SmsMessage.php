<?php

namespace App\Services\Sms;

use Exception;

class SmsMessage
{
    protected mixed $client;
    protected string $to = '';
    protected string $from = '';
    protected array $lines = [];

    public function __construct($lines = [])
    {
        $this->lines = $lines;
        $this->client = new Sms();
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    /** @throws Exception */
    public function send(): array
    {
        return $this->client->send([
            'to'        => $this->to,
            'from'      => $this->from,
            'message'   => join("\n", $this->lines)
        ]);
    }
}
