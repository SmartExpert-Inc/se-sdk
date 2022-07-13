<?php

Route::middleware([\SE\SDK\Middleware\Authenticate::class])
    ->get('migrate/database', \SE\SDK\Controllers\MigrateDatabase::class)
    ->name('migrate.database');