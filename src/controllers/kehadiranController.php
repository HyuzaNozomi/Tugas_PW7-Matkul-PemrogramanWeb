<?php
class kehadiranController {
    //proses data untuk request non-AJAX
    public function processPost($post) {
        $nama = htmlspecialchars(trim($post['nama'] ?? ''));
        $status = $post['status'] ?? '';
        $pesan = $this->getMessage($status);
        return ['nama' => $nama, 'status' => $status, 'pesan' => $pesan];
    }

    //proses data untuk request AJAX
    public function processAjax($post) {
        return $this->processPost($post);
    }

    //pesan berdasarkan status kehadiran
    private function getMessage($status) {
        switch ($status) {
            case 'Hadir':
                return 'Selamat Anda hadir hari ini';
            case 'Izin':
                return 'Anda izin, atau pura-pura izin hari ini';
            case 'Sakit':
                return 'Semoga cepat sembuh atau pura-pura sakit hari ini';
            case 'Tidak Hadir':
                return 'Anda tidak hadir hari ini atau bolos hari ini';
            default:
                return 'Status tidak valid';
        }
    }
}
?>