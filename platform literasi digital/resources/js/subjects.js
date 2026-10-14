import { loadData } from './learning-progress.js';

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('subjectSearch');
    const filterContainer = document.getElementById('filterContainer');
    const subjectsGrid = document.getElementById('subjectsGrid');
    const emptyState = document.getElementById('noResultsMessage');

    if (!searchInput || !filterContainer || !subjectsGrid || !emptyState) return;

    const cards = Array.from(subjectsGrid.querySelectorAll('.subject-card'));
    const filters = Array.from(filterContainer.querySelectorAll('[data-filter]'));
    let activeFilter = filterContainer.querySelector('[data-filter].active')?.dataset.filter ?? 'all';

    const normalize = (value) => value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLocaleLowerCase('id')
        .trim();

    const filterSubjects = () => {
        const query = normalize(searchInput.value);
        let visibleCount = 0;

        cards.forEach((card) => {
            const categories = (card.dataset.category ?? '').split(/\s+/);
            const searchableText = normalize(`${card.dataset.title ?? ''} ${card.textContent}`);
            const matchesCategory = activeFilter === 'all' || categories.includes(activeFilter);
            const matchesSearch = !query || searchableText.includes(query);
            const isVisible = matchesCategory && matchesSearch;

            card.hidden = !isVisible;
            if (isVisible) visibleCount += 1;
        });

        emptyState.classList.toggle('flex', visibleCount === 0);
        emptyState.hidden = visibleCount !== 0;
    };

    searchInput.addEventListener('input', filterSubjects);

    filterContainer.addEventListener('click', (event) => {
        const button = event.target.closest('[data-filter]');
        if (!button || !filterContainer.contains(button)) return;

        activeFilter = button.dataset.filter;
        filters.forEach((filter) => {
            const isActive = filter === button;
            filter.classList.toggle('active', isActive);
            filter.classList.toggle('inactive', !isActive);
            filter.setAttribute('aria-pressed', String(isActive));
        });

        filterSubjects();
    });

    filters.forEach((filter) => {
        filter.setAttribute('aria-pressed', String(filter.dataset.filter === activeFilter));
    });

    filterSubjects();
    loadSubjectProgress(subjectsGrid, document.getElementById('subject-progress-error'));
});

async function loadSubjectProgress(subjectsGrid, errorMessage) {
    try {
        const data = await loadData('all');

        subjectsGrid.querySelectorAll('.subject-card[data-quiz-id]').forEach((card) => {
            const progress = data.subjectProgress?.[card.dataset.quizId];
            if (!progress || !Number.isFinite(progress.percentage) || !Number.isFinite(progress.attempts)) {
                throw new Error(`Data progres untuk pelajaran "${card.dataset.quizId}" tidak tersedia.`);
            }

            const percentage = Math.min(Math.max(progress.percentage, 0), 100);
            const percentageLabel = card.querySelector('[data-subject-percentage]');
            const progressLabel = card.querySelector('[data-subject-progress-label]');
            const progressBar = card.querySelector('[role="progressbar"]');
            const progressFill = progressBar?.querySelector('.progress-bar-fill');

            if (!percentageLabel || !progressLabel || !progressBar || !progressFill) {
                throw new Error(`Tampilan progres pelajaran "${card.dataset.quizId}" tidak lengkap.`);
            }

            percentageLabel.textContent = `${percentage}%`;
            progressLabel.textContent = progress.attempts
                ? `Nilai terbaik · ${progress.attempts} percobaan`
                : 'Belum dikerjakan';
            progressFill.style.width = `${percentage}%`;
            progressBar.setAttribute('aria-valuenow', String(percentage));
        });
    } catch (error) {
        if (!errorMessage) {
            throw error;
        }

        errorMessage.textContent = `Progres pelajaran gagal dimuat: ${error.message}`;
        errorMessage.hidden = false;
    }
}
