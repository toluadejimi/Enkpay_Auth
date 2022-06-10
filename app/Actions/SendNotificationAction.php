<?php

namespace App\Actions;

use App\DTOs\SendMessageData;
use Illuminate\Support\Facades\Http;

class SendNotificationAction
{
    protected static string $url;
    protected static string $projectID;
    protected static string $accessToken;

    public function __construct()
    {
        self::setProjectID();
        self::setAccessToken();
        self::setUrl();
    }

    protected function setAccessToken(): void
    {
        self::$accessToken = config('services.fcm.access_token');
    }

    protected function setProjectID(): void
    {
        self::$projectID = config('services.fcm.project_id');
    }

    protected function setUrl(): void
    {
        self::$url = "https://fcm.googleapis.com//v1/projects/".self::$projectID."/messages:send";
    }

    public static function execute(SendMessageData $request): void
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])
        ->withToken(self::$accessToken)
        ->post(self::$url, [
            "message" => [
                "token" => "",
                "notification" => [
                    "title" => $request->title,
                    "body"  => $request->body
                ]
            ]
        ])->json();
    }
}
