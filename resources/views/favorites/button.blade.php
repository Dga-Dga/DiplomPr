<button class="cover-action favorite-action" data-book-id="{{ $book->id }}"
    data-favorited="{{ $book->isFavorited() ? 'true' : 'false' }}"
    title="{{ $book->isFavorited() ? 'Удалить из избранного' : 'Добавить в избранное' }}">
    <i class="{{ $book->isFavorited() ? 'fas' : 'far' }} fa-heart"></i>
</button>