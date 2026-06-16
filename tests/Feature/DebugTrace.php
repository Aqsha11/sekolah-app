<?php

use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;

/**
 * Debug: override Role::findByName temporarily to capture backtrace
 */
beforeEach(function () {
    // Register a handler that converts RoleDoesNotExist to a more informative error
});

it('traces the exception', function () {
    try {
        $this->get('/login');
    } catch (RoleDoesNotExist $e) {
        $trace = $e->getTrace();
        dump('Full trace:', $trace);
        throw $e; // Re-throw so test still fails
    }
});
