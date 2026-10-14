import { loadData } from './learning-progress.js';

const periods = [
    { label: 'Last 7 Days', value: '7d' },
    { label: 'Last 30 Days', value: '30d' },
    { label: 'This Term', value: 'term' },
    { label: 'All Time', value: 'all' },
];
let activePeriod = periods[1];
let isLoading = false;

document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    renderDashboard();
    window.setInterval(renderDashboard, 30000);
});

async function renderDashboard() {
    if (isLoading) return;
    isLoading = true;
    showError('');

    try {
        const data = await loadData(activePeriod.value);
        renderStats(data.stats);
        renderCompletedLessons(data.results, data.stats.totalResults);
        renderActivity(data.progress.activityDates);
        renderBadges(data.badgeFlags);
    } catch (error) {
        showError(`Progress gagal dimuat: ${error.message}`);
    } finally {
        isLoading = false;
    }
}

function renderStats(stats) {
    animateValue('.metrics-grid .stat-card:nth-child(1) .stat-value', stats.totalXP, (value) => (
        `${value.toLocaleString()} <span class="stat-unit">XP</span>`
    ));

    const weeklyTrend = document.querySelector('.metrics-grid .stat-card:nth-child(1) .stat-trend');
    if (weeklyTrend) weeklyTrend.textContent = `+${stats.xpGainWeek} XP minggu ini`;

    animateValue('.metrics-grid .stat-card:nth-child(2) .stat-value', stats.lessonsCompleted);
    setText(
        '.metrics-grid .stat-card:nth-child(2) .stat-desc',
        `${stats.totalResults} percobaan quiz dalam ${stats.totalSubjects} mata pelajaran`,
    );

    animateValue('.metrics-grid .stat-card:nth-child(3) .stat-value', stats.accuracy, (value) => `${value}%`);
    setText(
        '.metrics-grid .stat-card:nth-child(3) .stat-trend',
        stats.totalResults ? `${stats.totalResults} hasil quiz dihitung` : 'Belum ada hasil quiz',
    );

    animateValue('.metrics-grid .stat-card:nth-child(4) .stat-value', stats.pace, (value) => `${value}%`);
    setText('.metrics-grid .stat-card:nth-child(4) .stat-desc', 'Modul quiz yang diselesaikan pada kurikulum');

    const progressBar = document.querySelector('.progress-bar-fill');
    if (progressBar) {
        progressBar.style.width = `${stats.pace}%`;
        progressBar.setAttribute('aria-valuenow', String(stats.pace));
    }
    setText('.curriculum-badges .primary-pill', `${stats.pace}% Finished`);
    setText('.curriculum-badges .secondary-pill', stats.pace ? 'In Progress' : 'Not Started');

    const completedLegend = document.querySelector('.progress-legend .legend-item:first-child');
    if (completedLegend) {
        completedLegend.innerHTML = `<span class="dot primary-dot"></span> ${stats.modulesCompleted} Modules Completed`;
    }
    const remainingLegend = document.querySelector('.progress-legend .legend-item:nth-child(2)');
    if (remainingLegend) {
        remainingLegend.innerHTML = `<span class="dot gray-dot"></span> ${stats.modulesRemaining} Remaining`;
    }
    setText(
        '.estimated-date',
        stats.modulesCompleted ? 'Progress diperbarui setelah quiz selesai' : 'Selesaikan quiz untuk mulai melacak progres',
    );
    setText('.streak-pill', `${stats.streakDays}-Day Streak`);
}

function animateValue(selector, end, formatter = (value) => value) {
    const element = document.querySelector(selector);
    if (!element) return;

    const start = Number.parseInt(element.textContent.replace(/[^\d]/g, ''), 10) || 0;
    const duration = 350;
    const startTimestamp = performance.now();

    function step(timestamp) {
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = Math.floor(progress * (end - start) + start);
        element.innerHTML = formatter(value);
        if (progress < 1) window.requestAnimationFrame(step);
    }

    window.requestAnimationFrame(step);
}

function setText(selector, text) {
    const element = document.querySelector(selector);
    if (element) element.textContent = text;
}

function showError(message) {
    let errorElement = document.getElementById('progress-load-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.id = 'progress-load-error';
        errorElement.setAttribute('role', 'alert');
        errorElement.className = 'progress-empty-message';
        document.querySelector('.metrics-grid')?.before(errorElement);
    }
    errorElement.textContent = message;
    errorElement.hidden = !message;
}

function renderCompletedLessons(results, totalResults) {
    const container = document.querySelector('.lesson-list');
    const footer = document.querySelector('.lesson-footer-prompt span');
    if (!container) return;

    container.replaceChildren();
    if (!results.length) {
        const message = document.createElement('p');
        message.textContent = 'Belum ada hasil quiz untuk periode ini. Selesaikan quiz untuk melihat progres Anda.';
        message.className = 'progress-empty-message';
        container.append(message);
    } else {
        results.forEach((result) => {
            const item = document.createElement('article');
            item.className = 'lesson-item';

            const left = document.createElement('div');
            left.className = 'lesson-left';
            const icon = document.createElement('div');
            icon.className = 'lesson-badge-icon math-bg';
            icon.innerHTML = '<span class="material-symbols-outlined" aria-hidden="true">quiz</span>';

            const details = document.createElement('div');
            const title = document.createElement('h3');
            title.textContent = result.title;
            const meta = document.createElement('div');
            meta.className = 'lesson-meta';
            appendMeta(meta, result.subject);
            appendMeta(meta, new Date(result.completedAt).toLocaleString('id-ID'));
            appendMeta(meta, `${result.correctAnswers}/${result.totalQuestions} jawaban benar`);
            details.append(title, meta);
            left.append(icon, details);

            const right = document.createElement('div');
            right.className = 'lesson-right';
            const score = document.createElement('div');
            score.className = 'lesson-score';
            const scoreValue = document.createElement('span');
            const percentage = Math.round((result.correctAnswers / result.totalQuestions) * 100);
            scoreValue.className = `score-value${percentage === 100 ? ' text-secondary' : ''}`;
            scoreValue.textContent = `${percentage}%`;
            const scoreLabel = document.createElement('span');
            scoreLabel.className = 'score-label';
            scoreLabel.textContent = 'Quiz Score';
            score.append(scoreValue, scoreLabel);
            right.append(score);
            item.append(left, right);
            container.append(item);
        });
    }

    if (footer) {
        const shown = results.length;
        footer.textContent = `Menampilkan ${shown} hasil terbaru dari ${totalResults} — ${activePeriod.label}`;
    }
}

function appendMeta(container, text) {
    const separator = document.createElement('span');
    separator.textContent = '•';
    const value = document.createElement('span');
    value.textContent = text;
    container.append(separator, value);
}

function renderActivity(activityDates = []) {
    const tracker = document.querySelector('.tracker-grid');
    if (!tracker) return;

    const activeDays = new Set(activityDates);
    const today = new Date();
    const days = [];
    for (let offset = 6; offset >= 0; offset -= 1) {
        const date = new Date(today);
        date.setDate(today.getDate() - offset);
        days.push(date);
    }

    tracker.replaceChildren();
    days.forEach((date) => {
        const key = getDateKey(date);
        const isToday = key === getDateKey(new Date());
        const isActive = activeDays.has(key);
        const day = document.createElement('div');
        day.className = 'tracker-day';

        const weekday = document.createElement('span');
        weekday.textContent = new Intl.DateTimeFormat('en', { weekday: 'short' }).format(date).slice(0, 1);
        const circle = document.createElement('div');
        circle.className = `tracker-circle ${isActive ? 'checked' : isToday ? 'today' : 'empty'}`;
        const content = document.createElement('span');
        if (isActive) {
            content.className = 'material-symbols-outlined';
            content.textContent = 'check';
        } else if (isToday) {
            content.className = 'material-symbols-outlined';
            content.textContent = 'schedule';
        } else {
            content.className = 'empty-dot';
        }
        circle.append(content);

        const label = document.createElement('span');
        label.className = `tracker-date${isToday ? ' today-text' : ''}`;
        label.textContent = isToday
            ? 'Today'
            : new Intl.DateTimeFormat('en', { month: 'short', day: 'numeric' }).format(date);
        day.append(weekday, circle, label);
        tracker.append(day);
    });

    const tip = document.querySelector('.tracker-tip span:last-child');
    if (tip) {
        tip.textContent = activeDays.has(getDateKey(new Date()))
            ? 'Aktivitas belajar hari ini sudah tercatat.'
            : 'Selesaikan quiz hari ini untuk memulai atau melanjutkan streak.';
    }
}

function getDateKey(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function renderBadges(flags = {}) {
    const container = document.querySelector('.badges-list');
    const unlockedText = document.querySelector('.unlocked-text');
    if (!container) return;

    const badges = [];
    if (flags.completedFirstQuiz) {
        badges.push({ title: 'Quiz Starter', description: 'Menyelesaikan quiz pertama.', icon: 'school', style: 'primary-light' });
    }
    if (flags.hasPerfectScore) {
        badges.push({ title: 'Perfect Score', description: 'Mendapatkan nilai sempurna pada quiz.', icon: 'star', style: 'tertiary-light' });
    }
    if (flags.consistencyChamp) {
        badges.push({ title: 'Consistency Champ', description: 'Belajar setidaknya tiga hari berturut-turut.', icon: 'award_star', style: 'secondary-light' });
    }

    container.replaceChildren();
    if (!badges.length) {
        const message = document.createElement('p');
        message.textContent = 'Selesaikan quiz untuk membuka badge pencapaian.';
        container.append(message);
    } else {
        badges.forEach((badge) => {
            const item = document.createElement('div');
            item.className = 'badge-item';
            const icon = document.createElement('div');
            icon.className = `badge-icon-wrap ${badge.style}`;
            icon.innerHTML = `<span class="material-symbols-outlined" aria-hidden="true">${badge.icon}</span>`;
            const text = document.createElement('div');
            const titleRow = document.createElement('div');
            titleRow.className = 'badge-title-row';
            const title = document.createElement('h3');
            title.textContent = badge.title;
            const level = document.createElement('span');
            level.className = 'mini-tag';
            level.textContent = 'Earned';
            titleRow.append(title, level);
            const description = document.createElement('p');
            description.textContent = badge.description;
            text.append(titleRow, description);
            item.append(icon, text);
            container.append(item);
        });
    }

    if (unlockedText) unlockedText.textContent = `${badges.length} Unlocked`;
    setText('.showcase-btn', `View Badge Showcase (${Math.max(11 - badges.length, 0)} Locked)`);
}

function setupEventListeners() {
    const filterButton = document.querySelector('.btn-light');
    if (filterButton) {
        filterButton.addEventListener('click', () => {
            const currentIndex = periods.findIndex((period) => period.value === activePeriod.value);
            activePeriod = periods[(currentIndex + 1) % periods.length];
            filterButton.innerHTML = `<span class="material-symbols-outlined">calendar_today</span> ${activePeriod.label}`;
            renderDashboard();
        });
    }

    document.querySelector('.btn-primary')?.addEventListener('click', exportReport);

    const viewAllButton = document.querySelector('.view-all-btn');
    if (viewAllButton) {
        viewAllButton.disabled = false;
        viewAllButton.style.opacity = '';
        viewAllButton.style.cursor = '';
        viewAllButton.addEventListener('click', () => {
            activePeriod = periods[periods.length - 1];
            const button = document.querySelector('.btn-light');
            if (button) {
                button.innerHTML = `<span class="material-symbols-outlined">calendar_today</span> ${activePeriod.label}`;
            }
            renderDashboard();
        });
    }
}

function exportReport() {
    window.location.assign(`/progress/export?period=${encodeURIComponent(activePeriod.value)}`);
}
