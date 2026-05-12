//komunikasi ke server untuk submit form
export const ApiClient = {
    async submitForm(formData, csrfToken) {
        const response = await fetch(window.location.href, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': csrfToken
            },
            body: formData
        });

        const data = await response.json();
        return { response, data };
    }
};