/**
 * Hero Slider Functionality
 * Автоматический слайдер для главного баннера
 */
(function() {
    'use strict';

    // Находим слайдер на странице
    const slider = document.querySelector('.hero-slider');
    if (!slider) return;

    // Получаем элементы слайдера
    const slides = slider.querySelectorAll('.slide');
    const progressSegments = slider.querySelectorAll('.progress-segment');
    const segmentFills = slider.querySelectorAll('.segment-fill');
    const prevBtn = slider.querySelector('.slider-btn.prev');
    const nextBtn = slider.querySelector('.slider-btn.next');
    
    // Фиксированные настройки автоплея
    const isAutoplayEnabled = true;
    const autoplayDelay = 3500;

    // Если слайдов меньше 2, автоплей не нужен
    if (slides.length <= 1) return;

    let currentSlide = 0;
    let autoplayTimer = null;
    let isAutoplayPaused = false;
    let progressAnimationTimer = null;

    /**
     * Показать определенный слайд
     */
    function showSlide(index) {
        // Убираем активные классы
        slides.forEach(slide => slide.classList.remove('active'));

        // Добавляем активные классы
        slides[index].classList.add('active');
        
        // Обновляем полоску прогресса
        updateProgressBar(index);

        currentSlide = index;
    }

    /**
     * Обновить сегментированную полоску прогресса
     */
    function updateProgressBar(index, animate = false) {
        if (segmentFills.length <= 1) return;
        
        // Останавливаем предыдущую анимацию
        stopProgressAnimation();
        
        // Обновляем состояние всех сегментов
        segmentFills.forEach((fill, i) => {
            const segment = progressSegments[i];
            
            // Убираем все классы
            fill.classList.remove('animating', 'completed');
            segment.classList.remove('active');
            
            if (i < index) {
                // Предыдущие сегменты - полностью заполнены
                fill.classList.add('completed');
                fill.style.width = '100%';
            } else if (i === index) {
                // Текущий сегмент - активный
                segment.classList.add('active');
                fill.style.width = '0%';
                
                if (animate && !isAutoplayPaused) {
                    // Запускаем анимацию заполнения текущего сегмента
                    setTimeout(() => {
                        fill.classList.add('animating');
                        fill.style.transitionDuration = autoplayDelay + 'ms';
                        fill.style.width = '100%';
                    }, 50);
                }
            } else {
                // Будущие сегменты - пустые
                fill.style.width = '0%';
            }
        });
    }

    /**
     * Остановить анимацию прогресса
     */
    function stopProgressAnimation() {
        segmentFills.forEach(fill => {
            fill.classList.remove('animating');
            fill.style.transitionDuration = '0s';
        });
    }

    /**
     * Запустить анимацию прогресса для текущего слайда
     */
    function startProgressAnimation() {
        if (!isAutoplayPaused && segmentFills.length > 0) {
            updateProgressBar(currentSlide, true);
        }
    }

    /**
     * Переход к следующему слайду
     */
    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }

    /**
     * Переход к предыдущему слайду
     */
    function prevSlide() {
        const prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev);
    }

    /**
     * Запуск автоплея
     */
    function startAutoplay() {
        if (isAutoplayPaused) return;
        
        // Запускаем анимацию прогресса для текущего слайда
        startProgressAnimation();
        
        autoplayTimer = setInterval(() => {
            if (!isAutoplayPaused) {
                nextSlide();
                startProgressAnimation(); // Запускаем анимацию для нового слайда
            }
        }, autoplayDelay);
    }

    /**
     * Остановка автоплея
     */
    function stopAutoplay() {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
        stopProgressAnimation();
    }

    /**
     * Пауза автоплея при наведении
     */
    function pauseAutoplay() {
        isAutoplayPaused = true;
        stopAutoplay();
    }

    /**
     * Возобновление автоплея
     */
    function resumeAutoplay() {
        isAutoplayPaused = false;
        startAutoplay();
    }

    // Обработчики событий для кнопок навигации
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoplay();
            setTimeout(startAutoplay, 1000); // Пауза после ручного переключения
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoplay();
            setTimeout(startAutoplay, 1000); // Пауза после ручного переключения
        });
    }

    // Инициализация полоски прогресса
    updateProgressBar(currentSlide);
    
    // Запуск автоплея при загрузке только если включен в ACF
    if (isAutoplayEnabled) {
        startAutoplay();
    }

    // Убрали паузу при наведении - слайдер работает непрерывно

    // Убрали паузу при фокусе - слайдер работает непрерывно

    // Управление с клавиатуры
    slider.addEventListener('keydown', (e) => {
        switch(e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                prevSlide();
                stopAutoplay();
                setTimeout(startAutoplay, 1000);
                break;
            case 'ArrowRight':
                e.preventDefault();
                nextSlide();
                stopAutoplay();
                setTimeout(startAutoplay, 1000);
                break;
        }
    });

    // Убрали паузу при переключении вкладок - слайдер работает непрерывно

    // Поддержка touch событий для мобильных устройств
    let touchStartX = 0;
    let touchEndX = 0;

    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                nextSlide(); // Свайп влево - следующий слайд
            } else {
                prevSlide(); // Свайп вправо - предыдущий слайд
            }
        }
    }

    // Accessibility: сделать слайдер фокусируемым
    slider.setAttribute('tabindex', '0');
    slider.setAttribute('role', 'region');
    slider.setAttribute('aria-label', 'Галерея фотографій школи');

    console.log('Hero Slider initialized with', slides.length, 'slides');
})();
