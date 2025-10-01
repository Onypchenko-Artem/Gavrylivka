/**
 * Simple Lightbox for Gallery Images
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Simple Lightbox: Starting...');
    
    // Create lightbox HTML
    const lightboxHTML = `
        <div id="simple-lightbox" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 99999; cursor: pointer;">
            <div style="position: absolute; top: 20px; right: 20px; color: white; font-size: 30px; cursor: pointer; width: 50px; height: 50px; display: flex; justify-content: center; background: rgba(0,0,0,0.5); border-radius: 50%;">×</div>
            <div style="position: absolute; top: 50%; left: 20px; color: white; font-size: 30px; cursor: pointer; transform: translateY(-50%); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.5); border-radius: 50%; transition: all 0.3s ease; line-height: 1; font-weight: bold; text-align: center;">⟨</div>
            <div style="position: absolute; top: 50%; right: 20px; color: white; font-size: 30px; cursor: pointer; transform: translateY(-50%); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.5); border-radius: 50%; transition: all 0.3s ease; line-height: 1; font-weight: bold; text-align: center;">⟩</div>
            <img id="lightbox-img" style="max-width: 90%; max-height: 90%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div id="lightbox-counter" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: white; background: rgba(0,0,0,0.7); padding: 10px 20px; border-radius: 20px;"></div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', lightboxHTML);
    
    const lightbox = document.getElementById('simple-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCounter = document.getElementById('lightbox-counter');
    const closeBtn = lightbox.querySelector('div');
    const prevBtn = lightbox.querySelectorAll('div')[1];
    const nextBtn = lightbox.querySelectorAll('div')[2];
    
    // Add hover effects
    prevBtn.addEventListener('mouseenter', function() {
        this.style.background = 'rgba(255,255,255,0.2)';
        this.style.transform = 'translateY(-50%) scale(1.1)';
    });
    
    prevBtn.addEventListener('mouseleave', function() {
        this.style.background = 'rgba(0,0,0,0.5)';
        this.style.transform = 'translateY(-50%) scale(1)';
    });
    
    nextBtn.addEventListener('mouseenter', function() {
        this.style.background = 'rgba(255,255,255,0.2)';
        this.style.transform = 'translateY(-50%) scale(1.1)';
    });
    
    nextBtn.addEventListener('mouseleave', function() {
        this.style.background = 'rgba(0,0,0,0.5)';
        this.style.transform = 'translateY(-50%) scale(1)';
    });
    
    closeBtn.addEventListener('mouseenter', function() {
        this.style.background = 'rgba(59, 130, 246, 0.8)';
        this.style.transform = 'scale(1.1)';
    });
    
    closeBtn.addEventListener('mouseleave', function() {
        this.style.background = 'rgba(0,0,0,0.5)';
        this.style.transform = 'scale(1)';
    });
    
    let currentIndex = 0;
    let images = [];
    
    // Get all gallery images
    function getImages() {
        const galleryItems = document.querySelectorAll('.gallery-item[data-lightbox="gallery"]');
        images = Array.from(galleryItems).map(item => ({
            src: item.href,
            alt: item.querySelector('img').alt
        }));
        console.log('Simple Lightbox: Found', images.length, 'images');
    }
    
    // Show lightbox
    function showLightbox(index) {
        currentIndex = index;
        lightboxImg.src = images[currentIndex].src;
        lightboxImg.alt = images[currentIndex].alt;
        lightboxCounter.textContent = `${currentIndex + 1} / ${images.length}`;
        lightbox.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    // Hide lightbox
    function hideLightbox() {
        lightbox.style.display = 'none';
        document.body.style.overflow = '';
    }
    
    // Next image
    function nextImage() {
        if (currentIndex < images.length - 1) {
            showLightbox(currentIndex + 1);
        } else {
            showLightbox(0);
        }
    }
    
    // Previous image
    function prevImage() {
        if (currentIndex > 0) {
            showLightbox(currentIndex - 1);
        } else {
            showLightbox(images.length - 1);
        }
    }
    
    // Event listeners
    closeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        hideLightbox();
    });
    
    prevBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        prevImage();
    });
    
    nextBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        nextImage();
    });
    
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            hideLightbox();
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (lightbox.style.display === 'block') {
            if (e.key === 'Escape') hideLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        }
    });
    
    // Gallery click handler
    document.addEventListener('click', function(e) {
        if (e.target.closest('.gallery-item[data-lightbox="gallery"]')) {
            e.preventDefault();
            console.log('Simple Lightbox: Gallery item clicked');
            getImages();
            
            const clickedItem = e.target.closest('.gallery-item');
            const clickedIndex = Array.from(document.querySelectorAll('.gallery-item[data-lightbox="gallery"]')).indexOf(clickedItem);
            
            if (clickedIndex !== -1) {
                showLightbox(clickedIndex);
            }
        }
    });
    
    console.log('Simple Lightbox: Initialized');
});
