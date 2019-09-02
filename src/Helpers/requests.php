<?php

if (! function_exists('requests')) {
    function requests()
    {
        return app()->make('requests');
    }
}