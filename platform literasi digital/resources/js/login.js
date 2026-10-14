const form = document.getElementById('login-form');
const errorBox = document.getElementById('auth-errors');

if (form instanceof HTMLFormElement && errorBox) {
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton?.textContent ?? '';

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        errorBox.replaceChildren();
        errorBox.hidden = true;

        const formData = new FormData(form);
        const email = formData.get('email');
        if (typeof email === 'string') {
            formData.set('email', email.trim().toLowerCase());
        }

        if (submitButton instanceof HTMLButtonElement) {
            submitButton.disabled = true;
            submitButton.textContent = 'Sedang masuk...';
        }
        form.setAttribute('aria-busy', 'true');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            if (response.ok && response.redirected) {
                window.location.assign(response.url);
                return;
            }

            let payload;
            try {
                payload = await response.json();
            } catch {
                throw new Error(
                    response.status === 419
                        ? 'Sesi login kedaluwarsa. Muat ulang halaman lalu coba lagi.'
                        : `Login gagal (HTTP ${response.status}). Coba lagi beberapa saat lagi.`,
                );
            }

            const validationMessages = payload.errors
                ? Object.values(payload.errors).flat()
                : [];
            const message = validationMessages.length
                ? validationMessages.join(' ')
                : payload.message;

            throw new Error(message || 'Email atau password tidak sesuai.');
        } catch (error) {
            const message = error instanceof Error
                ? error.message
                : 'Tidak dapat menghubungi server. Periksa koneksi lalu coba lagi.';
            const paragraph = document.createElement('p');
            paragraph.textContent = message;
            errorBox.append(paragraph);
            errorBox.hidden = false;
            errorBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } finally {
            form.removeAttribute('aria-busy');
            if (submitButton instanceof HTMLButtonElement) {
                submitButton.disabled = false;
                submitButton.textContent = originalButtonText;
            }
        }
    });
}
