/**
 * Simple Lightbox for Gallery Images
 */

(function() {
    'use strict';

    // Create lightbox HTML structure
    function createLightboxHTML() {
        const lightboxHTML = `
            <div id="lightbox" class="lightbox" style="display: none;">
                <div class="lightbox-overlay"></div>
                <div class="lightbox-content">
                    <button class="lightbox-close" aria-label="Закрити">&times;</button>
                    <button class="lightbox-prev" aria-label="Попереднє зображення">‹</button>
                    <button class="lightbox-next" aria-label="Наступне зображення">›</button>
                    <div class="lightbox-image-container">
                        <img class="lightbox-image" src="" alt="">
                        <div class="lightbox-caption"></div>
                    </div>
                    <div class="lightbox-counter"></div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', lightboxHTML);
    }

    // Add lightbox styles
    function addLightboxStyles() {
        const styles = `
            <style>
            .lightbox {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .lightbox-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                cursor: pointer;
            }
            
            .lightbox-content {
                position: relative;
                max-width: 90vw;
                max-height: 90vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .lightbox-image-container {
                position: relative;
                max-width: 100%;
                max-height: 100%;
            }
            
            .lightbox-image {
                max-width: 100%;
                max-height: 90vh;
                object-fit: contain;
                display: block;
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            }
            
            .lightbox-close {
                position: absolute;
                top: -40px;
                right: 0;
                background: rgba(255, 255, 255, 0.9);
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                font-size: 24px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                z-index: 10001;
            }
            
            .lightbox-close:hover {
                background: white;
                transform: scale(1.1);
            }
            
            .lightbox-prev,
            .lightbox-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255, 255, 255, 0.9);
                border: none;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                font-size: 24px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                z-index: 10001;
            }
            
            .lightbox-prev {
                left: -60px;
            }
            
            .lightbox-next {
                right: -60px;
            }
            
            .lightbox-prev:hover,
            .lightbox-next:hover {
                background: white;
                transform: translateY(-50%) scale(1.1);
            }
            
            .lightbox-caption {
                position: absolute;
                bottom: -40px;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 10px 15px;
                border-radius: 4px;
                text-align: center;
                font-size: 14px;
            }
            
            .lightbox-counter {
                position: absolute;
                top: -40px;
                left: 0;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 8px 15px;
                border-radius: 20px;
                font-size: 14px;
            }
            
            @media (max-width: 768px) {
                .lightbox-prev {
                    left: 10px;
                }
                
                .lightbox-next {
                    right: 10px;
                }
                
                .lightbox-close {
                    top: 10px;
                    right: 10px;
                }
            }
            </style>
        `;
        
        document.head.insertAdjacentHTML('beforeend', styles);
    }

    // Initialize lightbox
    function initLightbox() {
        console.log('Lightbox: Initializing...');
        createLightboxHTML();
        addLightboxStyles();
        
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = lightbox.querySelector('.lightbox-image');
        const lightboxCaption = lightbox.querySelector('.lightbox-caption');
        const lightboxCounter = lightbox.querySelector('.lightbox-counter');
        const closeBtn = lightbox.querySelector('.lightbox-close');
        const prevBtn = lightbox.querySelector('.lightbox-prev');
        const nextBtn = lightbox.querySelector('.lightbox-next');
        const overlay = lightbox.querySelector('.lightbox-overlay');
        
        let currentIndex = 0;
        let images = [];
        
        // Get all gallery images
        function getGalleryImages() {
            const galleryItems = document.querySelectorAll('.gallery-item[data-lightbox="gallery"]');
            images = Array.from(galleryItems).map(item => ({
                src: item.href,
                alt: item.querySelector('img').alt,
                element: item
            }));
        }
        
        // Show lightbox
        function showLightbox(index) {
            currentIndex = index;
            const image = images[currentIndex];
            
            lightboxImage.src = image.src;
            lightboxImage.alt = image.alt;
            lightboxCaption.textContent = image.alt || '';
            lightboxCounter.textContent = `${currentIndex + 1} / ${images.length}`;
            
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Focus management
            closeBtn.focus();
        }
        
        // Hide lightbox
        function hideLightbox() {
            lightbox.style.display = 'none';
            document.body.style.overflow = '';
        }
        
        // Show next image
        function showNext() {
            if (currentIndex < images.length - 1) {
                showLightbox(currentIndex + 1);
            } else {
                showLightbox(0); // Loop to first
            }
        }
        
        // Show previous image
        function showPrev() {
            if (currentIndex > 0) {
                showLightbox(currentIndex - 1);
            } else {
                showLightbox(images.length - 1); // Loop to last
            }
        }
        
        // Event listeners
        closeBtn.addEventListener('click', hideLightbox);
        overlay.addEventListener('click', hideLightbox);
        nextBtn.addEventListener('click', showNext);
        prevBtn.addEventListener('click', showPrev);
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (lightbox.style.display === 'none') return;
            
            switch(e.key) {
                case 'Escape':
                    hideLightbox();
                    break;
                case 'ArrowRight':
                    showNext();
                    break;
                case 'ArrowLeft':
                    showPrev();
                    break;
            }
        });
        
        // Gallery item click handlers
        document.addEventListener('click', function(e) {
            console.log('Lightbox: Click detected', e.target);
            if (e.target.closest('.gallery-item[data-lightbox="gallery"]')) {
                e.preventDefault();
                console.log('Lightbox: Gallery item clicked');
                getGalleryImages();
                console.log('Lightbox: Found images:', images.length);
                
                const clickedItem = e.target.closest('.gallery-item');
                const clickedIndex = images.findIndex(img => img.element === clickedItem);
                console.log('Lightbox: Clicked index:', clickedIndex);
                
                if (clickedIndex !== -1) {
                    showLightbox(clickedIndex);
                }
            }
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLightbox);
    } else {
        initLightbox();
    }
    
    // Also try to initialize after a short delay
    setTimeout(function() {
        if (!document.getElementById('lightbox')) {
            console.log('Lightbox: Retrying initialization...');
            initLightbox();
        }
    }, 1000);
    
})();
