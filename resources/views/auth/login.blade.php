<form method="POST" action="{{ route('login') }}">
    @csrf
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Пароль" required>
    <label>
        <input type="checkbox" name="remember"> Запомнить меня
    </label>
    <button type="submit">Войти</button>
</form>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Выйти</button>
</form>