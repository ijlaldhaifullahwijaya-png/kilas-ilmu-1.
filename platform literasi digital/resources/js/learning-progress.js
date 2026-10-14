async function requestJson(url, options = {}) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const response = await fetch(url, {
        ...options,
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            ...(options.body ? { 'Content-Type': 'application/json' } : {}),
            ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
            ...options.headers,
        },
    });
    const data = await response.json();

    if (!response.ok) {
        const validationMessage = data.errors
            ? Object.values(data.errors).flat().join(' ')
            : null;
        throw new Error(validationMessage || data.message || 'Permintaan gagal. Silakan coba lagi.');
    }

    return data;
}

function loadData(period = '30d') {
    return requestJson(`/progress/data?period=${encodeURIComponent(period)}`);
}

function recordQuizResult(quizId, answers, attemptId) {
    return requestJson('/quiz/results', {
        method: 'POST',
        body: JSON.stringify({ quizId, attemptId, answers }),
    });
}

export { loadData, recordQuizResult };
