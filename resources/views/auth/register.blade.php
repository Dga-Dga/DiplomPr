<form method="POST" action="{{ route('register') }}">
    @csrf
    <input name="name" placeholder="Имя" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="phone" placeholder="Телефон (необязательно)">
    <input name="password" type="password" placeholder="Пароль" required>
    <input name="password_confirmation" type="password" placeholder="Пароль ещё раз" required>
    <button type="submit">Зарегистрироваться</button>
</form>