<?php
// Konfigurasi path error log (sesuaikan jika perlu)
if (!defined('ERROR_LOG_PATH')) {
    define('ERROR_LOG_PATH', '/opt/lampp/htdocs/form-kehadiran/logs/error.log');
}

// pemberiathuan error ke file log dengan format yang jelas
function logError($message, $context = []) {
    $log = '[' . date('Y-m-d H:i:s') . '] ' . $message;
    if (!empty($context)) {
        $log .= ' | Context: ' . json_encode($context);
    }
    $log .= ' | IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . PHP_EOL;
    error_log($log, 3, ERROR_LOG_PATH);
}

// mengirim response JSON untuk AJAX request
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// membuat token CSRF baru jika belum ada, dan mengembalikannya
function getCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// regenerasi token CSRF setelah digunakan untuk mencegah replay attack 
function regenerateCsrfToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

//validasi token CSRF yang diterima dari form dengan yang disimpan di session
function validateCsrfToken($token) {
    if (empty($token) || !hash_equals($_SESSION['csrf_token'], $token)) {
        logError('CSRF token mismatch', ['received_token' => substr($token, 0, 10) . '...']);
        return false;
    }
    return true;
}
?>