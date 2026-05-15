import './bootstrap';
document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Делегирование клика по всем кнопкам избранного
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.favorite-action');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        // Блокируем кнопку на время запроса
        if (btn.disabled) return;
        btn.disabled = true;

        const bookId = btn.dataset.bookId;
        const currentState = btn.dataset.favorited === 'true';
        const method = currentState ? 'DELETE' : 'POST';
        const url = `/favorites/${bookId}`;

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            });

            if (!response.ok) throw new Error('Ошибка сервера');

            const data = await response.json(); // ожидаем { favorited: true/false }
            const newState = data.favorited ?? !currentState; // fallback на переключение, если сервер вернул не то

            // Обновляем кнопку: состояние, иконку, title
            btn.dataset.favorited = newState ? 'true' : 'false';
            btn.title = newState ? 'Удалить из избранного' : 'Добавить в избранное';
            const icon = btn.querySelector('i');
            if (icon) {
                icon.className = newState ? 'fas fa-heart' : 'far fa-heart';
            }

            // Обновляем счётчик в шапке
            const countSpan = document.querySelector('.favorites-count');
            if (countSpan) {
                let count = parseInt(countSpan.textContent) || 0;
                count = newState ? count + 1 : Math.max(0, count - 1);
                countSpan.textContent = count;
            }

            // Если мы на странице избранного и произошло удаление – прячем карточку
            if (!newState && window.location.pathname === '/favorites') {
                const card = btn.closest('.book-card');
                if (card) {
                    card.style.opacity = '0';
                    card.style.transition = 'opacity 0.3s';
                    setTimeout(() => card.remove(), 300);
                }
            }
        } catch (error) {
            console.error(error);
            alert('Не удалось выполнить действие. Попробуйте позже.');
        } finally {
            btn.disabled = false;
        }
    });
});