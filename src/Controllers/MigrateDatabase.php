<?php

namespace SE\SDK\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class MigrateDatabase extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        Artisan::call('migrate --force');
        Artisan::call('db:seed --force');

        return response()->json(['success' => true]);
    }
}