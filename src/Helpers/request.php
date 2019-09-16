<?php

if (! function_exists('request')) {
    function requests()
    {
        return app()->make('request');
    }
}