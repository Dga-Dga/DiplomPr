<form action="{{ route('cart.store', $book) }}" method="POST" class="book-actions" style="margin-top: 10px;">
    @csrf
    <button type="submit" class="btn buy-btn">
        <span>Купить</span>
    </button>
</form>