<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'twilio' => [
        'sid'            => env('TWILIO_SID'),
        'token'          => env('TWILIO_TOKEN'),
        'whatsapp_from'  => env('TWILIO_WHATSAPP_FROM', 'whatsapp:+14155238886'),
    ],

    'whatsapp' => [
        'provider'        => env('WHATSAPP_PROVIDER', 'twilio'), // 'twilio' or 'meta'
        'verify_token'    => env('WHATSAPP_VERIFY_TOKEN', 'learnhub-webhook'),
        'allowed_numbers' => env('WHATSAPP_ALLOWED_NUMBERS', ''), // comma-separated E.164
        'meta_token'      => env('WHATSAPP_META_TOKEN'),
        'meta_phone_id'   => env('WHATSAPP_META_PHONE_ID'),
    ],

    'anthropic' => [
        'api_key' => env('ANTHROPIC_API_KEY'),
    ],

    'agent' => [
        'secret' => env('AGENT_SECRET'),
    ],

];
