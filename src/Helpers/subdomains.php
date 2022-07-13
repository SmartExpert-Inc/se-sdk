<?php

use Illuminate\Support\Facades\Config;

if (! function_exists('short_url')) {
    function short_url(string $url): string
    {
        return preg_replace('#^https?://#', '', rtrim($url, '/'));
    }
}