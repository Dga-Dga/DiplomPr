@extends('books.layout')
@include('layouts.base')

@section('content')
<div class="about-company">
    <h1>О нашей компании</h1>

    <p class="intro">
        «Литбук» — это маленькая компания с большим уважением к печатному слову. Мы начинали как двое друзей, которые просто обожали книги, а теперь помогаем сотням читателей находить «ту самую» историю.
    </p>

    <div class="highlight">
        <p>Наша миссия — сделать чтение доступным, уютным и вдохновляющим. Мы не гонимся за скоростью, мы создаём пространство, где каждая книга ждёт своего читателя.</p>
    </div>

    <h2>Как всё начиналось</h2>
    <p>
        В 2023 году мы собрали свою первую полку из 30 книг в съёмной квартире. Сначала предлагали знакомым редкие издания, потом запустили онлайн-витрину, а сейчас формируем ассортимент с душой. Офиса у нас пока нет — всё работает из небольшого склада и через сайт, но каждый заказ мы упаковываем так, словно дарим подарок.
    </p>

    <h2>Что мы предлагаем?</h2>
    <ul class="features-list">
        <li><strong>Художественная литература</strong> — от классики до современной прозы.</li>
        <li><strong>Детские книги</strong> — проверенные издания, которые хочется перечитывать.</li>
        <li><strong>Редкие и тематические подборки</strong> — для коллекционеров и любителей нишевых жанров.</li>
        <li><strong>Канцелярия и книжные аксессуары</strong> — закладки, блокноты, уютные мелочи.</li>
    </ul>

    <h2>Почему выбирают нас</h2>
    <div class="values">
        <div class="value-item">
            <span class="value-icon">🤝</span>
            <p>Мы общаемся с каждым клиентом лично — помогаем выбрать книгу под настроение.</p>
        </div>
        <div class="value-item">
            <span class="value-icon">📦</span>
            <p>Бережная упаковка и оперативная отправка по всей России.</p>
        </div>
        <div class="value-item">
            <span class="value-icon">🌱</span>
            <p>Мы растём медленно, зато честно — без навязчивой рекламы и «громких» акций.</p>
        </div>
    </div>

    <p class="closing">
        Если вы ищете книгу, которую приятно держать в руках, или хотите порадовать близкого осмысленным подарком — добро пожаловать в «Литбук». Мы всегда рады новым читателям!
    </p>
</div>
@endsection

<style>
    /* Стили страницы "О компании" */
.about-company {
    max-width: 780px;
    margin: 0 auto;
    padding: 50px 20px 60px;
    font-family: 'Georgia', 'Times New Roman', serif;
    color: #3d3d3d;
    line-height: 1.8;
}

.about-company h1 {
    font-size: 2.5em;
    font-weight: normal;
    color: #2c3e50;
    margin-bottom: 25px;
    border-bottom: 2px solid #e0c8a8;
    padding-bottom: 15px;
}

.about-company h2 {
    font-size: 1.6em;
    font-weight: normal;
    color: #4a4a4a;
    margin-top: 40px;
    margin-bottom: 15px;
}

.about-company p {
    font-size: 1.1em;
    margin-bottom: 1.5em;
    text-align: justify;
}

.intro {
    font-style: italic;
    font-size: 1.15em;
}

/* Блок с миссией — выделенный */
.highlight {
    background: #faf7f2;
    border-left: 5px solid #c8966c;
    padding: 20px 25px;
    margin: 30px 0;
    font-style: italic;
    border-radius: 0 8px 8px 0;
}

.highlight p {
    margin: 0;
}

/* Список преимуществ */
.features-list {
    list-style: none;
    padding: 0;
    margin: 20px 0 30px;
}

.features-list li {
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="%23c8966c"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>') left center no-repeat;
    padding-left: 30px;
    margin-bottom: 12px;
    font-size: 1.05em;
}

/* Блок с ценностями */
.values {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    margin: 30px 0;
}

.value-item {
    flex: 1 1 200px;
    background: #ffffff;
    border: 1px solid #eae2d7;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    transition: box-shadow 0.2s;
}

.value-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.value-icon {
    font-size: 2rem;
    display: block;
    margin-bottom: 10px;
}

.value-item p {
    font-size: 0.95em;
    text-align: center;
    color: #555;
    margin: 0;
}

/* Заключительный абзац */
.closing {
    margin-top: 40px;
    font-size: 1.1em;
    text-align: center;
    color: #5a4636;
    font-style: italic;
}

/* Адаптивность для телефонов */
@media (max-width: 600px) {
    .about-company {
        padding: 30px 15px 40px;
    }
    .about-company h1 {
        font-size: 2em;
    }
    .values {
        flex-direction: column;
    }
}
</style>