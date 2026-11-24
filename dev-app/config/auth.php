<?php

return [
    'defaults' => ['guard' => 'web', 'passwords' => 'users'],
    'guards' => [
        'web' => ['driver' => 'session', 'provider' => 'users'],
        'player' => ['driver' => 'session', 'provider' => 'players'],
    ],
    'providers' => [
        'users' => ['driver' => 'eloquent', 'model' => Whodoku\Models\User::class],
        'players' => ['driver' => 'eloquent', 'model' => Whodoku\Models\Player::class],
    ],
    'passwords' => [],
];
