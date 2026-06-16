<?php

use Database\Seeders\RolePermissionSeeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Temporary debug test to trace where RoleDoesNotExist is thrown
 */
beforeEach(function () {
    // Override findByName to log caller
    // We'll use error_log to capture the backtrace
    set_error_handler(function ($severity, $message, $file, $line) {
        // no-op
    });
});

it('catches and logs the backtrace', function () {
    // Monkey-patch findByName to log backtrace
    $exception = null;
    try {
        // Just try to access a simple route
        $this->get('/login');
    } catch (RoleDoesNotExist $e) {
        $exception = $e;
    }

    // If we caught the exception, dump the trace
    if ($exception) {
        dump("=== ROLE DOES NOT EXIST TRACE ===");
        // Get the trace manually
        $reflect = new ReflectionClass($exception);
        $trace = $reflect->getMethod('getTrace')->invoke($exception);
        dump($trace);
    }
});
