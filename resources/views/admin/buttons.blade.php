@if(auth()->user()->isAdmin() || auth()->user()->isManager())
    <a href="{{ route('books.edit', $book) }}" class="cover-action edit-action" title="Редактировать">
        <i class="fas fa-pen"></i>
    </a>

    <!-- Кнопка удалить левый нижний угол -->
    <form action="{{ route('books.destroy', $book) }}" method="POST" class="cover-action delete-action"
        onsubmit="return confirm('Удалить книгу?')">
        @csrf
        @method('DELETE')
        <button type="submit" title="Удалить">
            <i class="fas fa-trash"></i>
        </button>
    </form>
@endif