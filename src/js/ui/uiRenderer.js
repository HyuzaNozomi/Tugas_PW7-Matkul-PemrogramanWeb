import { DomManager } from '../dom/domManager.js';

export const UiRenderer = {
    dismissTimeout: null,

    escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, (m) => {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    },

    scheduleDismiss() {
        const resultDiv = DomManager.getResultArea();
        if (this.dismissTimeout) clearTimeout(this.dismissTimeout);
        this.dismissTimeout = setTimeout(() => {
            resultDiv.classList.add('opacity-0', 'translate-y-[-10px]');
            setTimeout(() => {
                resultDiv.classList.add('hidden');
                resultDiv.classList.remove('opacity-0', 'translate-y-[-10px]');
                resultDiv.innerHTML = '';
            }, 500);
        }, 1500);
    },

    setResultBaseClass() {
        const resultDiv = DomManager.getResultArea();
        resultDiv.classList.remove('hidden', 'opacity-0', 'translate-y-[-10px]');
        resultDiv.className = 'mb-6 p-4 rounded-2xl glass-notif transition-all duration-500';
    },

    clearErrors() {
        DomManager.getNamaError().classList.add('hidden');
        DomManager.getStatusError().classList.add('hidden');
    },

    showValidationErrors(errors) {
        this.clearErrors();
        if (errors.nama) {
            const namaErr = DomManager.getNamaError();
            namaErr.textContent = errors.nama;
            namaErr.classList.remove('hidden');
        }
        if (errors.status) {
            const statusErr = DomManager.getStatusError();
            statusErr.textContent = errors.status;
            statusErr.classList.remove('hidden');
        }
    },

    showResult(data) {
        if (this.dismissTimeout) clearTimeout(this.dismissTimeout);
        this.setResultBaseClass();
        const resultDiv = DomManager.getResultArea();
        resultDiv.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 font-semibold text-sm">Kehadiran Tersimpan</p>
                    <div class="mt-1.5 space-y-0.5">
                        <p class="text-gray-500 text-xs"><span class="text-gray-700">Nama:</span> ${this.escapeHtml(data.nama)}</p>
                        <p class="text-gray-500 text-xs"><span class="text-gray-700">Status:</span> ${this.escapeHtml(data.status)}</p>
                        <p class="text-gray-500 text-xs"><span class="text-gray-700">Pesan:</span> ${this.escapeHtml(data.pesan)}</p>
                    </div>
                </div>
                <button onclick="this.closest('#resultArea').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors ml-3 shrink-0">
                    <span class="text-lg leading-none">&times;</span>
                </button>
            </div>
        `;
        DomManager.getForm().reset();
        const csrfInput = document.querySelector('input[name="csrf_token"]');
        if (csrfInput && data.csrf_token) {
            csrfInput.value = data.csrf_token;
        }
        this.scheduleDismiss();
    },

    showServerError(errorMessage) {
        if (this.dismissTimeout) clearTimeout(this.dismissTimeout);
        this.setResultBaseClass();
        const resultDiv = DomManager.getResultArea();
        resultDiv.innerHTML = `
            <div class="flex items-start">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 font-semibold text-sm">Error</p>
                    <p class="text-gray-500 text-xs mt-1">${this.escapeHtml(errorMessage)}</p>
                </div>
                <button onclick="this.closest('#resultArea').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors ml-3 shrink-0">
                    <span class="text-lg leading-none">&times;</span>
                </button>
            </div>
        `;
        this.scheduleDismiss();
    },

    showValidationErrorsFromServer(errors) {
        if (this.dismissTimeout) clearTimeout(this.dismissTimeout);
        this.setResultBaseClass();
        const resultDiv = DomManager.getResultArea();
        let errorList = '';
        for (let key in errors) {
            errorList += '<li class="text-gray-500 text-xs">' + this.escapeHtml(errors[key]) + '</li>';
        }
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
        this.scheduleDismiss();
    }
};
