/**
 * Gallery Slider Script (Carousel with multiple images)
 * Скрипт каруселі галереї з лентою фотографій
 */

document.addEventListener('DOMContentLoaded', function() {
	const slider = document.querySelector('.gallery-slider');
	
	if (!slider) {
		return;
	}

	const slides = slider.querySelectorAll('.gallery-slide');
	const prevBtn = document.querySelector('.gallery-nav-prev');
	const nextBtn = document.querySelector('.gallery-nav-next');
	const container = document.querySelector('.gallery-slider-container');

	if (slides.length === 0) {
		return;
	}

	let currentIndex = 0;
	const totalSlides = slides.length;

	// Calculate slides per view based on viewport
	function getSlidesPerView() {
		const width = window.innerWidth;
		if (width > 1200) {
			return 4;
		} else if (width > 900) {
			return 3;
		} else if (width > 768) {
			return 2;
		} else {
			return 1;
		}
	}

	// Get gap between slides
	function getSlideGap() {
		return window.innerWidth > 768 ? 20 : 15;
	}

	// Calculate max scroll index
	function getMaxIndex() {
		const slidesPerView = getSlidesPerView();
		return Math.max(0, totalSlides - slidesPerView);
	}

	// Update slider position
	function updateSlider() {
		const slidesPerView = getSlidesPerView();
		const gap = getSlideGap();
		const slideWidth = slides[0].offsetWidth;
		const moveDistance = (slideWidth + gap) * currentIndex;
		
		slider.style.transform = `translateX(-${moveDistance}px)`;
		
		// Update button states
		updateButtons();
	}

	// Update button states
	function updateButtons() {
		const maxIndex = getMaxIndex();
		
		if (prevBtn) {
			prevBtn.disabled = currentIndex === 0;
		}
		
		if (nextBtn) {
			nextBtn.disabled = currentIndex >= maxIndex;
		}
	}

	// Next slide
	function nextSlide() {
		const maxIndex = getMaxIndex();
		if (currentIndex < maxIndex) {
			currentIndex++;
			updateSlider();
		}
	}

	// Previous slide
	function prevSlide() {
		if (currentIndex > 0) {
			currentIndex--;
			updateSlider();
		}
	}

	// Event listeners
	if (nextBtn) {
		nextBtn.addEventListener('click', nextSlide);
	}

	if (prevBtn) {
		prevBtn.addEventListener('click', prevSlide);
	}

	// Auto-play (optional - every 4 seconds)
	let autoplayInterval = setInterval(() => {
		const maxIndex = getMaxIndex();
		if (currentIndex >= maxIndex) {
			currentIndex = 0;
		} else {
			currentIndex++;
		}
		updateSlider();
	}, 4000);

	// Pause autoplay on hover
	const sliderWrapper = document.querySelector('.gallery-slider-wrapper');
	if (sliderWrapper) {
		sliderWrapper.addEventListener('mouseenter', () => {
			clearInterval(autoplayInterval);
		});

		sliderWrapper.addEventListener('mouseleave', () => {
			autoplayInterval = setInterval(() => {
				const maxIndex = getMaxIndex();
				if (currentIndex >= maxIndex) {
					currentIndex = 0;
				} else {
					currentIndex++;
				}
				updateSlider();
			}, 4000);
		});
	}

	// Keyboard navigation
	document.addEventListener('keydown', (e) => {
		if (e.key === 'ArrowLeft') {
			prevSlide();
		} else if (e.key === 'ArrowRight') {
			nextSlide();
		}
	});

	// Touch/swipe support
	let touchStartX = 0;
	let touchEndX = 0;

	if (container) {
		container.addEventListener('touchstart', (e) => {
			touchStartX = e.changedTouches[0].screenX;
		}, { passive: true });

		container.addEventListener('touchend', (e) => {
			touchEndX = e.changedTouches[0].screenX;
			handleSwipe();
		}, { passive: true });
	}

	function handleSwipe() {
		const swipeThreshold = 50;
		const diff = touchStartX - touchEndX;

		if (Math.abs(diff) > swipeThreshold) {
			if (diff > 0) {
				// Swipe left - next slide
				nextSlide();
			} else {
				// Swipe right - previous slide
				prevSlide();
			}
		}
	}

	// Update on window resize
	let resizeTimeout;
	window.addEventListener('resize', () => {
		clearTimeout(resizeTimeout);
		resizeTimeout = setTimeout(() => {
			// Reset to valid index if needed
			const maxIndex = getMaxIndex();
			if (currentIndex > maxIndex) {
				currentIndex = maxIndex;
			}
			updateSlider();
		}, 250);
	});

	// Initial setup
	updateSlider();
});
