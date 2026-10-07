<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    protected static bool $isDatabaseReady = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! static::$isDatabaseReady) {
            $dbConnection = config('database.default');

            if ($dbConnection === 'sqlite') {
                $dbFile = config('database.connections.sqlite.database');
                if ($dbFile && $dbFile !== ':memory:') {
                    $resolvedPath = str_starts_with($dbFile, DIRECTORY_SEPARATOR) || (strlen($dbFile) > 2 && $dbFile[1] === ':')
                        ? $dbFile
                        : base_path($dbFile);

                    if (! file_exists($resolvedPath)) {
                        @mkdir(dirname($resolvedPath), 0755, true);
                        touch($resolvedPath);
                    }
                }
            }

            if (! Schema::hasTable('users')) {
                Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
            }

            static::$isDatabaseReady = true;
        }
    }
}
