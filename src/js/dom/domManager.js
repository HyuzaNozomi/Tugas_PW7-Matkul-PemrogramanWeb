//mengelola DOM untuk menampilkan pesan hasil submit
export const DomManager = {
    getForm() {
        return document.getElementById('kehadiranForm');
    },
    getNamaInput() {
        return document.getElementById('nama');
    },
    getStatusSelect() {
        return document.getElementById('status');
    },
    getNamaError() {
        return document.getElementById('namaError');
    },
    getStatusError() {
        return document.getElementById('statusError');
    },
    getResultArea() {
        return document.getElementById('resultArea');
    },
    getCsrfTokenValue() {
        const input = document.querySelector('input[name="csrf_token"]');
        return input ? input.value : '';
    }
};