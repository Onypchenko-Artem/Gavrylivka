/**
 * Reading Progress Bar for Single Posts
 * Shows progress of article reading
 */

document.addEventListener('DOMContentLoaded', function() {
    // Create progress bar element
    const progressBar = document.createElement('div');
    progressBar.className = 'reading-progress';
    progressBar.setAttribute('aria-hidden', 'true');
    document.body.prepend(progressBar);

    // Calculate and update progress
    function updateProgress() {
        const article = document.querySelector('.entry-content');
        if (!article) return;

        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight - windowHeight;
        const scrollTop = window.pageYOffset;
        
        // Calculate progress percentage
        const progress = Math.min((scrollTop / documentHeight) * 100, 100);
        
        // Update progress bar width
        progressBar.style.width = progress + '%';
    }

    // Throttle scroll events for better performance
    let ticking = false;
    function handleScroll() {
        if (!ticking) {
            requestAnimationFrame(function() {
                updateProgress();
                ticking = false;
            });
            ticking = true;
        }
    }

    // Add scroll listener
    window.addEventListener('scroll', handleScroll);
    
    // Initial calculation
    updateProgress();

    // Smooth scroll to top when progress bar is clicked
    progressBar.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Add cursor pointer on hover
    progressBar.style.cursor = 'pointer';
    progressBar.title = 'Повернутися на початок сторінки';
});
