<?php

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'PluginBoilerplate\\';

    // does the class use the namespace prefix?
    $len = strlen($prefix);

    if ( strncmp($prefix, $class, $len) !== 0 ) {
        // no, move to the next registered autoloader
        return;
    }

    $routes = array(
        'PublicFeatures' => '/public/',
        'Admin' => '/admin/'
    );

    // get the relative class name
    $relative_class = substr( $class, $len );
    $first = strtok( $relative_class, '\\' );
    if (  array_key_exists( $first, $routes ) ) {
        $base_dir = __DIR__ . $routes[ $first ];
        $relative_class = substr( $class, $len + strlen($first) );
    }
    else {
        $base_dir = __DIR__ . '/includes/';
    }

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});