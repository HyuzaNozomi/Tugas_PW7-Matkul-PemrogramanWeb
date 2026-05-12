<?php

// Konfigurasi session
session_start();

// Tampilkan semua error untuk development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Path absolut
define('BASE_PATH', realpath(__DIR__ . '/..'));
define('CONTROLLER_PATH', BASE_PATH . '/src/controllers/kehadiranController.php');
define('VIEW_PATH', BASE_PATH . '/src/views/form.php');
define('HELPER_PATH', BASE_PATH . '/src/utils/helpers.php');

// Muat helper functions
if (!file_exists(HELPER_PATH)) {
    die('Helper file not found: ' . HELPER_PATH);
}
require_once HELPER_PATH;

// Deteksi request AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Load controller
try {
    if (!file_exists(CONTROLLER_PATH)) {
        throw new Exception('Controller file not found: ' . CONTROLLER_PATH);
    }
    require_once CONTROLLER_PATH;

    if (!class_exists('kehadiranController')) {
        throw new Exception('Class kehadiranController not found in ' . CONTROLLER_PATH);
    }
    $controller = new kehadiranController();
} catch (Exception $e) {
    logError('Controller loading failed', ['error' => $e->getMessage()]);
    if ($isAjax) {
        jsonResponse(['error' => 'Server error: ' . $e->getMessage()], 500);
    } else {
        die('<h1>Server Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>');
    }
}

// Proses request POST
$data = []; // data untuk view non-AJAX

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi CSRF token
    $csrfToken = null;
    if ($isAjax) {
        $headers = function_exists('getallheaders') ? getallheaders() : [];
        $csrfToken = $headers['X-CSRF-Token'] ?? $headers['X-CSRF-TOKEN'] ?? $_POST['csrf_token'] ?? null;
    } else {
        $csrfToken = $_POST['csrf_token'] ?? null;
    }

    if (!validateCsrfToken($csrfToken)) {
        logError('CSRF validation failed');
        if ($isAjax) {
            jsonResponse(['error' => 'CSRF token mismatch'], 403);
        } else {
            die('<h1>Security Error</h1><p>CSRF token mismatch. Please refresh the page.</p>');
        }
    }

    // Validasi input
    $nama_raw = trim($_POST['nama'] ?? '');
    $status_raw = trim($_POST['status'] ?? '');
    $allowedStatuses = ['Hadir', 'Izin', 'Sakit', 'Tidak Hadir'];

    $errors = [];
    if (empty($nama_raw)) {
        $errors['nama'] = 'Nama mahasiswa wajib diisi.';
    }
    if (empty($status_raw) || !in_array($status_raw, $allowedStatuses, true)) {
        $errors['status'] = 'Status kehadiran tidak valid.';
    }

    if (!empty($errors)) {
        if ($isAjax) {
            jsonResponse(['errors' => $errors], 422);
        } else {
            $data = ['errors' => $errors];
            include VIEW_PATH;
            exit;
        }
    }

    // Proses data melalui controller
    try {
        if ($isAjax) {
            $result = $controller->processAjax($_POST);
            regenerateCsrfToken();
            $result['csrf_token'] = getCsrfToken();
            jsonResponse($result);
        } else {
            $data = $controller->processPost($_POST);
            regenerateCsrfToken();
        }
    } catch (Exception $e) {
        logError('Controller processing error', ['error' => $e->getMessage(), 'post' => $_POST]);
        if ($isAjax) {
            jsonResponse(['error' => 'Internal server error'], 500);
        } else {
            $data = ['error' => 'Terjadi kesalahan saat memproses data.'];
            include VIEW_PATH;
            exit;
        }
    }
}

// Tampilkan view untuk non-AJAX
$csrf_token = getCsrfToken(); // token untuk form

if (!file_exists(VIEW_PATH)) {
    die('<h1>Error</h1><p>View file not found: ' . htmlspecialchars(VIEW_PATH) . '</p>');
}
include VIEW_PATH;
?>