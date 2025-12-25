<?php
/**
 * @architect    Inactiveart (System Architect & UI Engineer)
 * @project      Inactiveart Official Portfolio (V1.0)
 * @copyright    2025 Inactiveart. All rights reserved.
 * @description  Authentication and session management system.
 */

session_start();
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/php-errors.log');

$sessionTimeout = 15 * 60;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessionTimeout)) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

define('ADMIN_USER', 'admin');
define('ADMIN_PASS_HASH', '$argon2id$v=19$m=65536,t=4,p=1$VnVCNkMubGZBL01wdjlyVA$50UG9lR0heKmwBBs1eTDjSiKRTtivC0e//Vwg7+3GnM');
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_ATTEMPT_WINDOW', 300);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


function login($username, $password)
{
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    $_SESSION['login_attempts'] = array_filter($_SESSION['login_attempts'], function ($ts) {
        return $ts > time() - LOGIN_ATTEMPT_WINDOW;
    });
    if (count($_SESSION['login_attempts']) >= MAX_LOGIN_ATTEMPTS) {
        error_log('Login rate limit exceeded for IP: ' . $_SERVER['REMOTE_ADDR']);
        return false;
    }
    $_SESSION['login_attempts'][] = time();

    if ($username === ADMIN_USER && password_verify($password, ADMIN_PASS_HASH)) {
        $_SESSION['logged_in'] = true;
        session_regenerate_id(true);
        $_SESSION['login_attempts'] = [];
        return true;
    }
    return false;
}


function logout()
{
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header("Location: admin.php");
    exit;
}


function isAuthenticated()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}
?>