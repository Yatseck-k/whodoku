<?php

use Whodoku\Http\Middleware\HandleInertiaRequests;

class DevInertiaRequests extends HandleInertiaRequests
{
    protected $rootView = 'whodoku';
}
