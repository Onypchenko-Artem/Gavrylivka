/**
 * Related News Slider Initialization
 * Uses Swiper.js for smooth sliding experience
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if Swiper is available and if the related news slider exists
    if (typeof Swiper !== 'undefined' && document.querySelector('.related-news-swiper')) {
        
        const relatedNewsSwiper = new Swiper('.related-news-swiper', {
            // Basic settings
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            speed: 800,
            
            // Responsive breakpoints
            breakpoints: {
                // When window width is >= 480px
                480: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                // When window width is >= 768px
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // When window width is >= 1024px
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
                // When window width is >= 1200px
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 30
                }
            },
            
            // Navigation arrows
            navigation: {
                nextEl: '.related-news-next',
                prevEl: '.related-news-prev',
            },
            
            // Pagination
            pagination: {
                el: '.related-news-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            
            // Effects
            effect: 'slide',
            
            // Accessibility
            a11y: {
                enabled: true,
                prevSlideMessage: 'Попередня новина',
                nextSlideMessage: 'Наступна новина',
                firstSlideMessage: 'Це перша новина',
                lastSlideMessage: 'Це остання новина',
            },
            
            // Keyboard control
            keyboard: {
                enabled: true,
                onlyInViewport: true,
            },
            
            // Mouse wheel control
            mousewheel: {
                enabled: false,
            },
            
            // Touch settings
            touchRatio: 1,
            touchAngle: 45,
            grabCursor: true,
            
            // Prevent clicks during transition
            preventClicks: true,
            preventClicksPropagation: true,
            
            // Events
            on: {
                init: function() {
                    // Add loaded class when slider is ready
                    this.el.classList.add('swiper-loaded');
                },
                
                slideChange: function() {
                    // Optional: Add analytics or other tracking here
                    console.log('Related news slide changed to:', this.activeIndex);
                },
                
                resize: function() {
                    // Recalculate slides on window resize
                    this.update();
                }
            }
        });
        
        // Pause autoplay when user hovers over the slider
        const sliderContainer = document.querySelector('.related-news-swiper');
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', function() {
                relatedNewsSwiper.autoplay.stop();
            });
            
            sliderContainer.addEventListener('mouseleave', function() {
                relatedNewsSwiper.autoplay.start();
            });
        }
        
        // Optional: Add intersection observer to start autoplay only when visible
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        relatedNewsSwiper.autoplay.start();
                    } else {
                        relatedNewsSwiper.autoplay.stop();
                    }
                });
            }, {
                threshold: 0.3
            });
            
            observer.observe(sliderContainer);
        }
    }
});
