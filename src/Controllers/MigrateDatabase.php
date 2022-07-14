<?php

namespace SE\SDK\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Artisan, Config, DB};

class MigrateDatabase extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        Config::set('database.connections.subdomain.database', "{$request->input('subdomain')}_{$request->input('host')}");
        Artisan::call('migrate:fresh --database=subdomain --force --seed');

        if ($request->input('host') == 'auth') {
            DB::setDefaultConnection('subdomain');
            Artisan::call('passport:install');
        }

        return response()->json(['success' => true]);
    }
}