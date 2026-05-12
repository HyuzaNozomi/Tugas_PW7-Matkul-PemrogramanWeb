document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('kehadiranForm');
    const resultDiv = document.getElementById('resultArea');
    let dismissTimeout = null;

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function scheduleDismiss() {
        if (dismissTimeout) clearTimeout(dismissTimeout);
        dismissTimeout = setTimeout(function() {
            resultDiv.classList.add('opacity-0', 'translate-y-[-10px]');
            setTimeout(function() {
                resultDiv.classList.add('hidden');
                resultDiv.classList.remove('opacity-0', 'translate-y-[-10px]');
                resultDiv.innerHTML = '';
            }, 500);
        }, 1500);
    }

    function showSuccess(data) {
        if (dismissTimeout) clearTimeout(dismissTimeout);
        resultDiv.classList.remove('hidden', 'opacity-0', 'translate-y-[-10px]');
        resultDiv.className = 'mb-6 p-4 rounded-2xl glass-notif transition-all duration-500';
        resultDiv.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 font-semibold text-sm">Kehadiran Tersimpan</p>
                    <div class="mt-1.5 space-y-0.5">
                        <p class="text-gray-500 text-xs"><span class="text-gray-700">Nama:</span> ${escapeHtml(data.nama)}</p>
                        <p class="text-gray-500 text-xs"><span class="text-gray-700">Status:</span> ${escapeHtml(data.status)}</p>
                        <p class="text-gray-500 text-xs"><span class="text-gray-700">Pesan:</span> ${escapeHtml(data.pesan)}</p>
                    </div>
                </div>
                <button onclick="this.closest('#resultArea').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors ml-3 shrink-0">
                    <span class="text-lg leading-none">&times;</span>
                </button>
            </div>
        `;
        form.reset();
        if (data.csrf_token) {
            document.querySelector('input[name="csrf_token"]').value = data.csrf_token;
        }
        scheduleDismiss();
    }

    function showError(message) {
        if (dismissTimeout) clearTimeout(dismissTimeout);
        resultDiv.classList.remove('hidden', 'opacity-0', 'translate-y-[-10px]');
        resultDiv.className = 'mb-6 p-4 rounded-2xl glass-notif transition-all duration-500';
        resultDiv.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 font-semibold text-sm">Error</p>
                    <p class="text-gray-500 text-xs mt-1">${escapeHtml(message)}</p>
                </div>
                <button onclick="this.closest('#resultArea').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors ml-3 shrink-0">
                    <span class="text-lg leading-none">&times;</span>
                </button>
            </div>
        `;
        scheduleDismiss();
    }

    function showValidationErrors(errors) {
        if (dismissTimeout) clearTimeout(dismissTimeout);
        resultDiv.classList.remove('hidden', 'opacity-0', 'translate-y-[-10px]');
        resultDiv.className = 'mb-6 p-4 rounded-2xl glass-notif transition-all duration-500';
        resultDiv.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 font-semibold text-sm">Validasi Gagal</p>
                    <ul class="mt-1.5 space-y-0.5 list-disc list-inside">${errorList}</ul>
                </div>
                <button onclick="this.closest('#resultArea').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors ml-3 shrink-0">
                    <span class="text-lg leading-none">&times;</span>
                </button>
            </div>
        `;
        scheduleDismiss();
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const nama = document.getElementById('nama').value.trim();
        const status = document.getElementById('status').value;
        let valid = true;

        if (nama === '') {
            document.getElementById('namaError').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('namaError').classList.add('hidden');
        }
        if (status === '') {
            document.getElementById('statusError').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('statusError').classList.add('hidden');
        }

        if (!valid) return;

        const formData = new FormData(form);
        formData.append('submit', true);
        const csrfToken = document.querySelector('input[name="csrf_token"]').value;

        try {
            const response = await fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': csrfToken
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                showSuccess(data);
            } else if (response.status === 422 && data.errors) {
                showValidationErrors(data.errors);
            } else if (response.status === 403) {
                showError(data.error || 'CSRF token tidak valid. Muat ulang halaman.');
            } else {
                showError(data.error || 'Terjadi kesalahan server.');
            }
        } catch (err) {
            console.error(err);
            showError('Tidak dapat terhubung ke server. Periksa koneksi Anda.');
        }
    });
});
