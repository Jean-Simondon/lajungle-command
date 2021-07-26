<?php

// Uniquement accessible en PHP CLI
if ( PHP_SAPI !== 'cli') {
    echo "Only CLI access.\n";
    die( -1);
}

// Pas de version en dessous de 7.0.0 acceptée
if( version_compare( PHP_VERSION, '7.0.0', '<=') ) {
    printf( "Error: LJD-CLI requires PHP %s or newer. You are running version %s.\n", '5.6.0', PHP_VERSION );
    die( -1);
}

if( !file_exists( __DIR__ . '/../config/private_constant.php' )) {
    touch( __DIR__ . '/../config/private_constant.php' );
}

// Set common headers, to prevent warnings from plugins.
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
$_SERVER['HTTP_USER_AGENT'] = '';
$_SERVER['REQUEST_METHOD']  = 'GET';
$_SERVER['REMOTE_ADDR']     = '127.0.0.1';
