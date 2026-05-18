<!-- Слайдер -->
<div class="slider-container">
    <div class="slider" id="slider">

        <!-- Слайд 1 -->
        <div class="slide active">
            <a href="{{ route('company') }}">
                <img src="https://akhbarasabah.com/wp-content/uploads/2024/08/STARBUCKS_POST3_NEWS.jpg">
                <div class="slide-caption">О нашей компании</div>
            </a>
        </div>
        
        <!-- Слайд 2 -->
        <div class="slide">
            <a href="{{ route('books.index', ['new' => 1, 'search' => request('search'), 'genre' => request('genre')]) }}">
                    {{-- <i class="fas fa-tag" style="color: var(--orange-soft);"></i> Новинки недели --}}
                <img src="" alt="Новинки">
                <div class="slide-caption">Новинки недели – успей купить!</div>
            </a>
        </div>
        <!-- Слайд 3 -->
        <div class="slide">
            <a href="{{ route('books.index') }}">
                <img src="" alt="Детективы">
                <div class="slide-caption">Обратная связь</div>
            </a>
        </div>
    </div>

    <!-- Стрелки -->
    <button class="slider-btn prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="slider-btn next" onclick="changeSlide(1)">&#10095;</button>

    <!-- Точки -->
    <div class="slider-dots" id="sliderDots"></div>
</div>

<script>
     let currentSlide = 0;
    const slides = document.querySelectorAll('#slider .slide');
    const dotsContainer = document.getElementById('sliderDots');
    const totalSlides = slides.length;
    let autoSlideInterval;

    // Создаём точки
    function createDots() {
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }
    }

    // Показать слайд по индексу
    function goToSlide(index) {
        if (index < 0) index = totalSlides - 1;
        if (index >= totalSlides) index = 0;
        currentSlide = index;
        document.getElementById('slider').style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Обновляем активную точку
        document.querySelectorAll('.dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === currentSlide);
        });
    }

    // Переключение слайда (вызывается стрелками)
    function changeSlide(direction) {
        goToSlide(currentSlide + direction);
        resetAutoSlide();
    }

    // Автопрокрутка
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            goToSlide(currentSlide + 1);
        }, 5000);
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Инициализация
    createDots();
    goToSlide(0);
    startAutoSlide();
</script>

<style>/* Слайдер */
.slider-container {
    position: relative;
    max-width: 1000px;
    margin: 20px auto 30px;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.slider {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.slide {
    min-width: 100%;
    position: relative;
}

.slide img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    display: block;
}

.slide-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.5);
    color: rgb(255, 255, 255);
    padding: 12px 20px;
    font-weight: 600;
    font-size: 1.1rem;
}

/* Кнопки-стрелки */
.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.8);
    border: none;
    color: #333333;
    font-size: 24px;
    padding: 10px 14px;
    cursor: pointer;
    border-radius: 50%;
    transition: background 0.3s;
    z-index: 10;
}
.slider-btn:hover {
    background: white;
}
.prev { left: 10px; }
.next { right: 10px; }

/* Точки */
.slider-dots {
    text-align: center;
    padding: 10px 0;
    background: #f9f9f9;
}
.slider-dots .dot {
    display: inline-block;
    width: 12px;
    height: 12px;
    margin: 0 5px;
    background: #ccc;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.3s;
}
.slider-dots .dot.active {
    background: #e67e22;
}</style>