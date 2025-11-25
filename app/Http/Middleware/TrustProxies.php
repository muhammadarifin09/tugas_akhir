<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;   // ← WAJIB ditambahkan

class TrustProxies extends Middleware
{
    protected $proxies;

    protected $headers = Request::HEADER_X_FORWARDED_FOR 
                   | Request::HEADER_X_FORWARDED_HOST 
                   | Request::HEADER_X_FORWARDED_PORT 
                   | Request::HEADER_X_FORWARDED_PROTO;


}
