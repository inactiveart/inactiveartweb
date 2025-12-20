<?php
session_start();

// 1. AYARLAR: Güvenli şifre hashleme sistemi
// Şifre: Xk9#mP2!qLvz$88a (Argon2id ile hashlenmiş)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS_HASH', '$argon2id$v=19$m=65536,t=4,p=1$VnVCNkMubGZBL01wdjlyVA$50UG9lR0heKmwBBs1eTDjSiKRTtivC0e//Vwg7+3GnM');

// 2. CSRF TOKEN OLUŞTURMA (Form Saldırılarına Karşı)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 3. LOGIN FONKSİYONU
function login($username, $password)
{
    if ($username === ADMIN_USER && password_verify($password, ADMIN_PASS_HASH)) {
        $_SESSION['logged_in'] = true;
        // Session hijacking önlemek için ID yenile
        session_regenerate_id(true);
        return true;
    }
    return false;
}

// 4. LOGOUT FONKSİYONU
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

// 5. KONTROL FONKSİYONU
function isAuthenticated()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}
?>