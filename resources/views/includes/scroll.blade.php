<button class="scroll-to-top" aria-label="Вернуться наверх">
  ↑
</button>

<style>
    .scroll-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #333;
  color: #fff;
  border: none;
  cursor: pointer;
  font-size: 24px;
  line-height: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  opacity: 0;
  visibility: hidden;
  transform: translateY(20px);
  transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
  z-index: 1000;
}

.scroll-to-top.visible {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

/* Эффект при наведении */
.scroll-to-top:hover {
  background-color: #555;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
  const btn = document.querySelector('.scroll-to-top');
  const showThreshold = 300; // показывать кнопку после 300px прокрутки

  // Показываем/скрываем кнопку при скролле
  window.addEventListener('scroll', () => {
    if (window.scrollY > showThreshold) {
      btn.classList.add('visible');
    } else {
      btn.classList.remove('visible');
    }
  });

  // Плавная прокрутка вверх по клику
  btn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
});
</script>