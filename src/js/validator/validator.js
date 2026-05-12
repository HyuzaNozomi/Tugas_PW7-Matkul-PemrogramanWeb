//mengelola logika validasi form dan interaksi dengan controller
export const Validator = {
    validateNama(nama) {
        return nama.trim() !== '';
    },
    validateStatus(status) {
        return status !== '';
    },
    validateForm(formData) {
        const nama = formData.get('nama') || '';
        const status = formData.get('status') || '';
        const errors = {};

        if (!this.validateNama(nama)) {
            errors.nama = 'Nama harus diisi';
        }
        if (!this.validateStatus(status)) {
            errors.status = 'Pilih status';
        }

        return {
            isValid: Object.keys(errors).length === 0,
            errors: errors
        };
    }
};