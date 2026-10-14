import { recordQuizResult } from './learning-progress.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('quiz-form');
    if (!form) return;

    const steps = Array.from(form.querySelectorAll('.question-step'));
    const resultPanel = document.getElementById('quiz-result');
    const message = document.getElementById('quiz-message');
    const questionCount = document.getElementById('question-count');
    const progress = document.getElementById('question-progress');
    const previousButton = document.getElementById('previous-question');
    const nextButton = document.getElementById('next-question');
    const submitButton = document.getElementById('submit-quiz');
    let activeIndex = 0;

    if (!steps.length || !resultPanel || !message || !questionCount || !progress
        || !previousButton || !nextButton || !submitButton) return;

    const showStep = (index) => {
        activeIndex = index;
        steps.forEach((step, stepIndex) => {
            step.hidden = stepIndex !== activeIndex;
        });
        questionCount.textContent = `Soal ${activeIndex + 1} dari ${steps.length}`;
        progress.style.width = `${((activeIndex + 1) / steps.length) * 100}%`;
        progress.setAttribute('aria-valuenow', String(activeIndex + 1));
        previousButton.disabled = activeIndex === 0;
        nextButton.hidden = activeIndex === steps.length - 1;
        submitButton.hidden = activeIndex !== steps.length - 1;
        message.hidden = true;
        steps[activeIndex].querySelector('legend')?.focus();
    };

    const hasAnswer = (step) => Boolean(step.querySelector('input[type="radio"]:checked'));

    nextButton.addEventListener('click', () => {
        if (!hasAnswer(steps[activeIndex])) {
            message.textContent = 'Pilih satu jawaban dulu, ya! 😊';
            message.hidden = false;
            steps[activeIndex].querySelector('input[type="radio"]')?.focus();
            return;
        }

        showStep(activeIndex + 1);
    });

    previousButton.addEventListener('click', () => {
        if (activeIndex > 0) showStep(activeIndex - 1);
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (steps.some((step) => !hasAnswer(step))) {
            const firstUnanswered = steps.findIndex((step) => !hasAnswer(step));
            showStep(firstUnanswered);
            message.textContent = 'Masih ada soal yang belum dijawab. Yuk, lengkapi dulu!';
            message.hidden = false;
            return;
        }

        const answers = Object.fromEntries(
            steps.map((step) => {
                const answer = step.querySelector('input[type="radio"]:checked');
                return [answer.name, answer.value];
            }),
        );

        submitButton.disabled = true;
        submitButton.textContent = 'Memeriksa jawaban...';
        message.hidden = true;

        try {
            const { result, explanations } = await recordQuizResult(
                form.dataset.quizId,
                answers,
                form.dataset.attemptId,
            );
            const percentage = Math.round((result.correctAnswers / result.totalQuestions) * 100);
            document.getElementById('quiz-score').textContent = `${percentage}%`;
            document.getElementById('quiz-correct').textContent =
                `Kamu menjawab ${result.correctAnswers} dari ${result.totalQuestions} soal dengan benar.`;
            document.getElementById('result-encouragement').textContent = percentage === 100
                ? 'Luar biasa! Semua jawabanmu benar. Kamu hebat! 🌟'
                : percentage >= 60
                    ? 'Kerja bagus! Terus berlatih, kamu pasti makin jago! 💪'
                    : 'Terima kasih sudah mencoba! Belajar sedikit demi sedikit itu hebat. 😊';

            const explanationList = document.getElementById('quiz-explanations');
            explanationList.replaceChildren();
            explanations.forEach((entry, index) => {
                const item = document.createElement('li');
                item.textContent = `Soal ${index + 1}: ${entry.correct ? 'Benar! ' : 'Belum tepat. '}${entry.explanation}`;
                explanationList.append(item);
            });

            form.hidden = true;
            document.querySelector('.quiz-progress').hidden = true;
            resultPanel.hidden = false;
            resultPanel.focus();
        } catch (error) {
            message.textContent = `Hasil belum tersimpan: ${error.message}`;
            message.hidden = false;
            submitButton.disabled = false;
            submitButton.textContent = 'Selesai & lihat hasil 🎉';
        }
    });

    showStep(0);
});
