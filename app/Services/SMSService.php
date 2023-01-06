<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SMSService
{
    const BASE_URL = 'https://api.sendchamp.com/api/v1';

    public function sendSMS($to, $message, $route = 'international')
    {
        $response = Http::withHeaders([
            'Authorization' => env('SENDCHAMP_API_KEY'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post(self::BASE_URL . '/sms/send', [
            'sender_name' => env('SENDCHAMP_SENDER_NAME'),
            'to' => $to,
            'message' => $message,
            'route' => $route
        ]);

        return $response->json();
    }

    public function createSenderID()
    {
        $response = Http::withHeaders([
            'Authorization' => env('SENDCHAMP_API_KEY'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post(self::BASE_URL . '/sms/create-sender-id', [
            'name' => env('SENDCHAMP_SENDER_NAME'),
            'sample' => 'This is a sample message',
            'use_case' => 'Transactional & Marketing',
        ]);

        return $response->json();
    }
}
