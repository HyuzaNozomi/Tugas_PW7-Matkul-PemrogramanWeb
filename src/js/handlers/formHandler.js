import { DomManager } from '../dom/domManager.js';
import { Validator } from '../validator/validator.js';
import { UiRenderer } from '../ui/uiRenderer.js';
import { ApiClient } from '../api/apiClient.js';

//mengelola logika validasi form dan interaksi dengan controller
export const FormHandler = {
    async handleSubmit(event) {
        event.preventDefault();

        const form = DomManager.getForm();
        const formData = new FormData(form);
        formData.append('submit', true);

        const validation = Validator.validateForm(formData);
        if (!validation.isValid) {
            UiRenderer.showValidationErrors(validation.errors);
            return;
        }
        UiRenderer.clearErrors();

        const csrfToken = DomManager.getCsrfTokenValue();

        try {
            const { response, data } = await ApiClient.submitForm(formData, csrfToken);

            if (response.ok) {
                UiRenderer.showResult(data);
                // (opsional) form.reset();
            } else if (response.status === 422) {
                if (data.errors) {
                    UiRenderer.showValidationErrorsFromServer(data.errors);
                } else {
                    UiRenderer.showServerError(data.error || 'Data tidak valid');
                }
            } else if (response.status === 403) {
                UiRenderer.showServerError(data.error || 'CSRF token tidak valid. Muat ulang halaman.');
            } else {
                UiRenderer.showServerError(data.error || 'Terjadi kesalahan server');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            UiRenderer.showServerError('Tidak dapat terhubung ke server. Periksa koneksi Anda.');
        }
    },

    init() {
        const form = DomManager.getForm();
        if (form) {
            form.addEventListener('submit', this.handleSubmit.bind(this));
        }
    }
};