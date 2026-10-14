import { loadData } from './learning-progress.js';

let isLoading = false;

async function renderProgress() {
    if (isLoading) return;
    isLoading = true;

    const errorElement = document.getElementById('home-progress-error');
    try {
        const data = await loadData('all');
        const progress = data.progress;
        setText('streak-title', `${progress.currentStreak} day${progress.currentStreak === 1 ? '' : 's'} streak`);
        setText('streak-subtitle', `Personal best: ${progress.maxStreak} days`);
        setText('daily-goal-title', `Daily Goal: ${progress.dailyCompleted}/2 questions`);
        setText('daily-goal-subtitle', `${progress.dailyCompleted} completed today`);
        renderDailyGoal(progress.dailyCompleted);
        renderSubjectProgress(data.subjectProgress);
        if (errorElement) errorElement.hidden = true;
    } catch (error) {
        if (errorElement) {
            errorElement.textContent = `Progres gagal dimuat: ${error instanceof Error ? error.message : 'Terjadi kesalahan.'}`;
            errorElement.hidden = false;
        }
    } finally {
        isLoading = false;
    }
}

function setText(id, value) {
    const element = document.getElementById(id);
    if (element) element.textContent = value;
}

function renderDailyGoal(completed) {
    const percentage = Math.min(Math.max((completed / 2) * 100, 0), 100);
    const goalPath = document.querySelector('.goal-path-fill');
    const goalIcon = document.querySelector('.goal-icon');

    if (goalPath) goalPath.setAttribute('stroke-dasharray', `${percentage}, 100`);
    if (goalIcon) goalIcon.textContent = percentage >= 100 ? 'check' : 'remove';
}

function renderSubjectProgress(subjectProgress) {
    document.querySelectorAll('[data-home-subject]').forEach((card) => {
        const quizId = card.dataset.homeSubject;
        const progress = subjectProgress?.[quizId];
        if (!progress || !Number.isFinite(progress.percentage) || !Number.isFinite(progress.attempts)) {
            throw new Error(`Data progres untuk pelajaran "${quizId}" tidak tersedia.`);
        }

        const percentage = Math.min(Math.max(progress.percentage, 0), 100);
        const percentLabel = card.querySelector('[data-home-subject-percentage]');
        const attemptLabel = card.querySelector('[data-home-subject-attempts]');
        const progressFill = card.querySelector('[data-home-subject-fill]');

        if (!percentLabel || !attemptLabel || !progressFill) {
            throw new Error(`Tampilan progres pelajaran "${quizId}" tidak lengkap.`);
        }

        percentLabel.textContent = `${percentage}%`;
        attemptLabel.textContent = `${progress.attempts} percobaan`;
        progressFill.style.width = `${percentage}%`;
    });

    const featuredProgress = subjectProgress?.matematika;
    if (featuredProgress && Number.isFinite(featuredProgress.percentage)) {
        const percentage = Math.min(Math.max(featuredProgress.percentage, 0), 100);
        setText('featured-subject-percentage', `${percentage}%`);
        const progressFill = document.getElementById('featured-subject-progress');
        if (progressFill) progressFill.style.width = `${percentage}%`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    renderProgress();
    window.setInterval(renderProgress, 30000);
});
