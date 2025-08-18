<?php
namespace Dilip\CustomServicePerformance;

class Loader {
    public static function init() {
        // Bootstrap logic: load hooks, services, etc.
        add_action( 'init', [ __CLASS__, 'boot' ] );
    }

    public static function boot() {
        // Example: echo a log to confirm it's wired
        // error_log('Custom Service Performance Plugin Booted');
    }
}
