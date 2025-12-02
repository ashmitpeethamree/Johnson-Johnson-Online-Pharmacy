<?php

// Secure session starter
function session_start_secure() {
    if (session_status() === PHP_SESSION_NONE) {
        ini_set('session.cookie_httponly', '1');
        ini_set('session.use_strict_mode', '1');
        session_start();

        // Regenerate session every 15 minutes
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        }

        if (time() - $_SESSION['created'] > 900) {
            session_regenerate_id(true);
            $_SESSION['created'] = time();
        }
    }
}

// Escape output safely (prevents XSS)
function esc($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
