<?php
    date_default_timezone_set('Asia/Manila');
    ini_set('session.gc_maxlifetime', 3600); // 1 hour
    session_set_cookie_params(3600); // 1 hour

    session_set_cookie_params([
        'lifetime' => 3600, // 1 hour
        'path' => '/',
        'domain' => '', // Set to your domain
        'secure' => true, // Only send cookies over HTTPS
        'httponly' => true, // Only accessible through the HTTP protocol
        'samesite' => 'Strict' // Prevent CSRF attacks
    ]);

    // Start the session
    session_start();

    // Regenerate session ID every hour
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } elseif (time() - $_SESSION['CREATED'] > 3600) {
        // Session started more than 1 hour ago
        session_regenerate_id(true);    // Change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // Update creation time
    }