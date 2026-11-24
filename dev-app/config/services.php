<?php

return [
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'bot_username' => env('TELEGRAM_BOT_USERNAME'),
        'max_age_seconds' => 86400,
        'dev_login' => env('TELEGRAM_DEV_LOGIN', false),
    ],
    'yookassa' => [
        'shop_id' => env('YOOKASSA_SHOP_ID'),
        'secret_key' => env('YOOKASSA_SECRET_KEY'),
        'api_url' => 'https://api.yookassa.ru/v3',
        'webhook_ips' => [],
    ],
];
